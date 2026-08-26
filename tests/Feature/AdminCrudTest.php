<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Step;
use App\Models\Tutorial;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    protected function admin(): User
    {
        return User::query()->where('is_admin', true)->firstOrFail();
    }

    public function test_faq_full_crud_cycle(): void
    {
        $this->actingAs($this->admin());

        $create = $this->post(route('admin.faqs.store'), [
            'question' => 'Test question?',
            'answer' => 'Test answer.',
            'is_active' => '1',
        ]);
        $create->assertRedirect(route('admin.faqs.index'))
            ->assertSessionHas('success');

        $faq = Faq::query()->where('question', 'Test question?')->firstOrFail();
        $this->assertTrue($faq->is_active);
        $this->assertSame(7, $faq->sort);

        $update = $this->put(route('admin.faqs.update', ['id' => $faq->id]), [
            'question' => 'Edited question?',
            'answer' => 'Edited answer.',
        ]);
        $update->assertRedirect(route('admin.faqs.index'));

        $faq->refresh();
        $this->assertSame('Edited question?', $faq->question);
        $this->assertFalse($faq->is_active, 'Unset checkbox should deactivate the item.');

        $this->post(route('admin.faqs.move', ['id' => $faq->id, 'direction' => 'up']))
            ->assertSessionHas('success');

        $delete = $this->delete(route('admin.faqs.destroy', ['id' => $faq->id]));
        $delete->assertSessionHas('success');
        $this->assertModelMissing($faq);
    }

    public function test_plan_update_reflects_on_home_page(): void
    {
        $plan = Plan::query()->where('slug', 'tier-1-diy-navigator')->firstOrFail();

        $this->actingAs($this->admin())
            ->put(route('admin.plans.update', ['id' => $plan->id]), [
                'slug' => $plan->slug,
                'tier_label' => $plan->tier_label,
                'name' => $plan->name,
                'duration_label' => $plan->duration_label,
                'price_ind' => 1234,
                'price_joint' => 1567,
                'cta_label' => $plan->cta_label,
                'features' => "Feature one\nFeature two",
                'is_active' => '1',
            ])
            ->assertSessionHas('success');

        $this->get('/')
            ->assertSee('1,234')
            ->assertSee('data-joint="1,567"', false)
            ->assertSee('Feature one');
    }

    public function test_step_boolean_toggle_hides_from_site(): void
    {
        $step = Step::query()->where('title', 'Data input')->firstOrFail();
        $this->assertTrue($step->is_active);

        $this->actingAs($this->admin())
            ->put(route('admin.steps.update', ['id' => $step->id]), [
                'num_label' => $step->num_label,
                'title' => $step->title,
                'style' => 'normal',
            ]);

        $step->refresh();
        $this->assertFalse($step->is_active);

        $this->get('/')->assertDontSee('Guided prompts make sure nothing is missed.');
    }

    public function test_section_update_changes_heading_and_json_data(): void
    {
        $section = \App\Models\Section::query()->where('key', 'hero')->firstOrFail();

        $this->actingAs($this->admin())
            ->put(route('admin.sections.update', $section), [
                'heading' => 'New hero heading with <em>clarity</em>',
                'data_json' => json_encode([
                    'credit' => 'New credit line',
                    'note' => 'New note text',
                    'stage_caption' => 'New caption',
                ]),
            ])
            ->assertSessionHas('success');

        $section->refresh();
        $this->assertSame('New hero heading with <em>clarity</em>', $section->heading);
        $this->assertSame('New caption', $section->data('stage_caption'));

        $this->get('/')
            ->assertOk()
            ->assertSee('New hero heading with <em>clarity</em>', false)
            ->assertSee('New credit line')
            ->assertSee('New note text')
            ->assertSee('New caption');
    }

    public function test_section_update_rejects_invalid_json(): void
    {
        $section = \App\Models\Section::query()->where('key', 'faq')->firstOrFail();

        $this->actingAs($this->admin())
            ->from(route('admin.sections.edit', $section))
            ->put(route('admin.sections.update', $section), [
                'heading' => $section->heading,
                'data_json' => '{not valid json',
            ])
            ->assertSessionHasErrors('data_json');
    }

    public function test_settings_update_persists(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.settings.update'), [
                'site_name' => 'Next Chapter Renamed',
                'contact_email' => 'office@nextchapter.uk',
                'opening_hours' => 'Mon–Fri · 9:00–17:00',
                'location' => 'Bristol, UK',
                'legal_footnote' => 'Updated footnote.',
            ])
            ->assertSessionHas('success');

        $this->get('/')
            ->assertSee('office@nextchapter.uk')
            ->assertSee('Bristol, UK');
    }

    public function test_settings_brand_colors_and_logo_upload(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->put(route('admin.settings.update'), [
                'site_name' => 'Next Chapter',
                'color_primary' => 'FF5A00',
                'color_deep' => '#2C7CB8',
                'color_ink' => '#101010',
                'logo' => UploadedFile::fake()->image('logo.png', 200, 60),
            ])
            ->assertSessionHas('success')
            ->assertSessionHasNoErrors();

        $setting = Setting::get();
        $this->assertSame('#ff5a00', $setting->color_primary);
        $this->assertSame('#2c7cb8', $setting->color_deep);
        $this->assertSame('#101010', $setting->color_ink);
        $this->assertNull($setting->color_accent);

        $this->assertStringStartsWith('storage/brand/', $setting->logo_path);
        Storage::disk('public')->assertExists(substr($setting->logo_path, strlen('storage/')));

        $storedLogo = $setting->logo_path;

        $home = $this->get('/');
        $home->assertSee('--honey:#ff5a00', false);
        $home->assertSee('--ink:#101010', false);
        $this->assertStringNotContainsString('--brand-cyan:', $home->getContent());

        // replace logo: old file deleted, new one stored
        $this->actingAs($this->admin())
            ->put(route('admin.settings.update'), [
                'site_name' => 'Next Chapter',
                'logo' => UploadedFile::fake()->image('logo2.png', 200, 60),
            ])
            ->assertSessionHas('success');

        $setting = Setting::get();
        $this->assertNotSame($storedLogo, $setting->logo_path);
        Storage::disk('public')->assertMissing(substr($storedLogo, strlen('storage/')));

        // remove checkbox clears the path and deletes the file
        $currentFile = substr($setting->logo_path, strlen('storage/'));
        $this->actingAs($this->admin())
            ->put(route('admin.settings.update'), [
                'site_name' => 'Next Chapter',
                'remove_logo' => '1',
            ])
            ->assertSessionHas('success');

        $this->assertNull(Setting::get()->logo_path);
        Storage::disk('public')->assertMissing($currentFile);
    }

    public function test_settings_brand_color_validation_rejects_bad_hex(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.settings.update'), [
                'site_name' => 'Next Chapter',
                'color_primary' => 'not-a-color',
            ])
            ->assertSessionHasErrors('color_primary');
    }

    public function test_activity_tracker_logs_auth_content_and_public_events(): void
    {
        $this->post(route('admin.login.attempt'), [
            'email' => 'admin@nextchapter.uk',
            'password' => 'ChangeMe!2026',
        ]);
        $this->assertDatabaseHas('activity_logs', ['action' => 'auth.login']);

        $this->actingAs($this->admin())
            ->post(route('admin.faqs.store'), [
                'question' => 'Tracker test question?',
                'answer' => '<p>Yes.</p>',
            ])
            ->assertRedirect();
        $faq = Faq::query()->where('question', 'Tracker test question?')->first();

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'faq.created',
            'subject_id' => $faq->id,
        ]);

        $this->post(route('enquiries.store'), [
            'name' => 'Site Visitor',
            'email' => 'visitor@example.com',
            'message' => 'Hello, I need help.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('activity_logs', ['action' => 'contactmessage.created']);

        $this->actingAs($this->admin())
            ->delete(route('admin.faqs.destroy', $faq))
            ->assertRedirect();
        $this->assertDatabaseHas('activity_logs', ['action' => 'faq.deleted']);
    }

    public function test_message_show_marks_read_and_delete_works(): void
    {
        $message = ContactMessage::query()->create([
            'type' => 'enquiry',
            'name' => 'Someone',
            'email' => 'someone@example.com',
            'message' => 'Hello there.',
            'is_read' => false,
        ]);
        $this->assertFalse($message->is_read);

        $this->actingAs($this->admin())
            ->get(route('admin.messages.show', $message))
            ->assertOk()
            ->assertSee('Hello there.');

        $message->refresh();
        $this->assertTrue($message->is_read);

        $this->actingAs($this->admin())
            ->delete(route('admin.messages.destroy', $message))
            ->assertRedirect(route('admin.messages.index'));

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_tutorial_media_upload_replace_and_remove(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin());

        $create = $this->post(route('admin.tutorials.store'), [
            'title' => 'Media tutorial',
            'description' => '<p>Rich description.</p>',
            'duration' => '3:21',
            'is_active' => '1',
            'is_locked' => '1',
            'image' => UploadedFile::fake()->image('cover.png', 320, 180),
            'video' => UploadedFile::fake()->create('clip.mp4', 300, 'video/mp4'),
        ]);
        $create->assertRedirect(route('admin.tutorials.index'))->assertSessionHas('success');

        $tutorial = Tutorial::query()->where('title', 'Media tutorial')->firstOrFail();
        $this->assertNotNull($tutorial->image_path);
        $this->assertNotNull($tutorial->video_path);
        Storage::disk('public')->assertExists([$tutorial->image_path, $tutorial->video_path]);

        $originalImagePath = $tutorial->image_path;
        $newImage = UploadedFile::fake()->image('replacement.jpg');
        $this->post(route('admin.tutorials.update', $tutorial->id), [
            '_method' => 'PUT',
            'title' => 'Media tutorial',
            'description' => '<p>Rich description.</p>',
            'is_active' => '1',
            'is_locked' => '0',
            'image' => $newImage,
        ])->assertRedirect(route('admin.tutorials.index'));

        $tutorial->refresh();
        Storage::disk('public')->assertMissing($originalImagePath);
        Storage::disk('public')->assertExists((string) $tutorial->image_path);
        Storage::disk('public')->assertExists((string) $tutorial->video_path);

        $oldVideoPath = $tutorial->video_path;
        $this->post(route('admin.tutorials.update', $tutorial->id), [
            '_method' => 'PUT',
            'title' => 'Media tutorial',
            'is_active' => '1',
            'remove_video' => '1',
        ])->assertRedirect(route('admin.tutorials.index'));

        $tutorial->refresh();
        $this->assertNull($tutorial->video_path);
        Storage::disk('public')->assertMissing($oldVideoPath);

        $imagePath = $tutorial->image_path;
        $this->actingAs($this->admin())
            ->from(route('admin.tutorials.index'))
            ->delete(route('admin.tutorials.destroy', $tutorial->id))
            ->assertRedirect(route('admin.tutorials.index'));
        Storage::disk('public')->assertMissing($imagePath);
        $this->assertDatabaseMissing('tutorials', ['id' => $tutorial->id]);
    }
}
