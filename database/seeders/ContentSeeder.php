<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Faq;
use App\Models\PlatformFeature;
use App\Models\Plan;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Step;
use App\Models\Tutorial;
use App\Models\Value;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        Setting::query()->updateOrCreate(['id' => 1], [
            'site_name' => 'Next Chapter',
            'logo_path' => 'images/balancepoint-logo.png',
            'footer_logo_path' => 'images/nextchapter-footer.png',
            'meta_description' => 'Next Chapter helps you map your finances, model fair settlement scenarios and reach an agreement you both understand, powered by Balance Point, purpose-built modelling software built by a UK Chartered Certified Accountant.',
            'contact_email' => 'hello@nextchapter.uk',
            'opening_hours' => 'Mon–Fri · 9:00–17:30',
            'location' => 'United Kingdom',
            'disclaimer_bar_text' => '<strong>We offer no advice of any kind, financial or legal.</strong> Next Chapter is not a law firm and is not authorised or regulated by the Financial Conduct Authority (FCA). What we provide is negotiation and settlement modelling, future financial projection modelling, financial data automation, document automation and clarity, for individuals on their own and impartially for both parties on a joint package. Run by a UK Chartered Certified Accountant and experienced financial consultant. <strong>Legal drafting and specialist pension work sit outside what we do.</strong> Complex pensions need a report from a pension expert or actuary; we cannot produce one, but the figures from that report drop straight into the software.',
            'footer_blurb' => 'Financial clarity for separation and divorce, powered by Balance Point, purpose-built settlement software created by a UK Chartered Certified Accountant.',
            'copyright_holder' => 'Next Chapter Financial Divorce Settlement Ltd',
            'legal_footnote' => 'No advice of any kind, financial or legal. Not FCA-authorised.',
        ]);

        $sections = [
            [
                'key' => 'header',
                'name' => 'Header & navigation',
                'data' => [
                    'links' => [
                        ['label' => 'How it works', 'url' => '#how'],
                        ['label' => 'Balance Point', 'url' => '#software'],
                        ['label' => 'Demo', 'url' => '#demo'],
                        ['label' => 'Pricing', 'url' => '#pricing'],
                        ['label' => 'About', 'url' => '#about'],
                        ['label' => 'FAQ', 'url' => '#faq'],
                    ],
                ],
                'cta1_label' => 'View pricing',
                'cta1_url' => '#pricing',
            ],
            [
                'key' => 'hero',
                'name' => 'Hero',
                'eyebrow' => 'Financial clarity for separation & divorce',
                'heading' => 'Reach the right settlement, with <em>clarity</em> and far less strain.',
                'subheading' => 'Separation is draining, emotionally as much as financially, and it all comes down to one thing: settling well. Balance Point brings every figure together into one clear, easy tool that helps both parties reach a fair agreement faster, at lower cost, and with far less stress.',
                'cta1_label' => 'Choose your package',
                'cta1_url' => '#pricing',
                'cta2_label' => 'Watch the demo',
                'cta2_url' => '#demo',
                'data' => [
                    'credit' => 'Run by a UK Chartered Certified Accountant & experienced financial consultant',
                    'note' => 'We offer no advice of any kind, financial or legal. Work with us on your own, or take a joint package: because we give no advice and take no side, we can hold a private account for each of you and stay genuinely impartial between you.',
                    'stage_caption' => 'Both sides, the same complete picture, on the same terms.',
                ],
            ],
            [
                'key' => 'how-it-works',
                'name' => 'How it works',
                'eyebrow' => 'How it works',
                'heading' => 'Enter your finances once. We take you all the way to settlement.',
                'subheading' => 'Two things make a financial settlement slow and expensive: collating the data and completing the court forms, and then the negotiation itself, where months of letters between solicitors can run into many thousands of pounds. Balance Point tackles both.',
            ],
            [
                'key' => 'platform',
                'name' => 'Balance Point platform (dark band)',
                'eyebrow' => 'The Balance Point platform',
                'heading' => 'One tool built around the thing that matters most: the settlement.',
                'subheading' => 'Everything a financial settlement demands, in the order it matters. The settlement engine is where it all resolves; the rest clears the way to get you there.',
                'body' => 'Built by a UK Chartered Certified Accountant · your own secure, UK GDPR-compliant portal · we offer no advice of any kind',
            ],
            [
                'key' => 'demo',
                'name' => 'Demo & tutorials',
                'eyebrow' => 'See it in action',
                'heading' => 'Watch how Balance Point works.',
                'subheading' => 'A short walkthrough, plus step-by-step tutorials for every part of the process.',
                'video_url' => 'https://site.balancepoint.uk/uploads/videos/1776149095_hero_Video_Generation_Successful.mp4',
                'data' => [
                    'video_heading' => 'The full picture in under five minutes.',
                    'video_body' => 'Watch the whole process end to end: entering your finances through guided prompts that stop anything being missed, the mapping tool sorting your bank transactions into the right categories for you, and Form E, ES1 and ES2 populating themselves, ready to check, export and file, or hand to your solicitor. Then the part that actually decides the outcome: modelling different splits, setting your settlement zone and working through offers and counter-offers, alongside the questionnaire raised on the other side\'s disclosure and the 15-year projection showing what a proposed settlement really means for you years from now.',
                    'tutorials_lead' => 'The complete tutorial library',
                    'tutorials_sub' => 'Included with every package',
                    'tutorials_note' => 'The full tutorial library opens inside Balance Point once you\'ve chosen a package, under <strong>Get started</strong>.',
                ],
            ],
            [
                'key' => 'pricing',
                'name' => 'Pricing',
                'eyebrow' => 'Pricing',
                'heading' => 'Clear, fixed pricing, per case.',
                'subheading' => 'Choose the level of support you need. Every package includes your own secure Balance Point portal. Upgrade at any time.',
                'data' => [
                    'joint_note' => 'A joint application covers both parties and does not require you to be on good terms. <strong>You each get your own separate, private login and your own account access, and you each receive the full consultancy allocation for the tier.</strong> Because we offer no advice and take no side, we can hold an account for each of you without bias. All it takes is that you both agree to see the finances in the same clear format.',
                    'upgrade_banner_text' => '<strong>Start anywhere, move up whenever you need to.</strong> A simple case can turn complex, and you can upgrade to a higher tier at any time, with what you\'ve already paid credited towards it. Begin with a £295 Financial Clarity Session and, if you go on to a package, the £295 is discounted from the price and your session time carries forward.',
                ],
            ],
            [
                'key' => 'professionals',
                'name' => 'For professionals banner',
                'eyebrow' => 'For professionals',
                'heading' => 'White-label & partner services for law firms and mediators.',
                'body' => 'Bring Balance Point\'s financial modelling and document automation into your own practice, under your brand and on your terms. Referral partnerships and mediator networks available.',
                'cta1_label' => 'Enquire about partnerships',
                'cta1_url' => '#contact',
                'data' => ['tags' => ['Law firms', 'Mediators', 'White-label', 'Referral partners']],
            ],
            [
                'key' => 'about',
                'name' => 'About',
                'eyebrow' => 'About Next Chapter',
                'heading' => "Built by an accountant,\nfor one of life's hardest moments.",
                'body' => "Next Chapter was founded to bring genuine financial clarity to separation and divorce. Too many people go through it without ever seeing their finances laid out clearly, making life-changing decisions in the dark, or paying for every hour of it in legal fees.\n\nWe're different by design. As a Chartered Certified Accountant and experienced financial consultant, our founder built Balance Point to do the financial heavy lifting properly: structured, transparent, and modelled so both parties can see what a fair outcome actually looks like.\n\nWe don't replace your solicitor or offer legal advice. We do the numbers clearly, fairly and rigorously, so the legal process is faster and far less costly.",
                'data' => ['sig' => 'Clarity is the fairest place to start.'],
            ],
            [
                'key' => 'faq',
                'name' => 'FAQ',
                'eyebrow' => 'Questions',
                'heading' => 'The things people ask us most.',
            ],
            [
                'key' => 'contact',
                'name' => 'Final CTA / contact',
                'eyebrow' => 'Start here',
                'heading' => 'Begin your next chapter with clarity.',
                'subheading' => 'Choose a package and get instant access to your secure portal, or start with a conversation.',
                'cta1_label' => 'Choose your package',
                'cta1_url' => '#pricing',
                'cta2_label' => 'Book a Clarity Session',
                'cta2_url' => 'mailto:hello@nextchapter.uk',
            ],
            [
                'key' => 'footer',
                'name' => 'Footer link columns',
                'data' => [
                    'columns' => [
                        ['title' => 'Product', 'links' => [
                            ['label' => 'Balance Point', 'url' => '#software'],
                            ['label' => 'How it works', 'url' => '#how'],
                            ['label' => 'Demo & tutorials', 'url' => '#demo'],
                            ['label' => 'Pricing', 'url' => '#pricing'],
                        ]],
                        ['title' => 'Company', 'links' => [
                            ['label' => 'About', 'url' => '#about'],
                            ['label' => 'FAQ', 'url' => '#faq'],
                            ['label' => 'Contact', 'url' => '#contact'],
                            ['label' => 'For professionals', 'url' => '#pricing'],
                        ]],
                        ['title' => 'Legal', 'links' => [
                            ['label' => 'Legal & Policies', 'url' => '/legal'],
                            ['label' => 'Privacy & GDPR', 'url' => '/legal#privacy'],
                            ['label' => 'Refunds', 'url' => '/legal#refunds'],
                            ['label' => 'Complaints', 'url' => '/legal#complaints'],
                        ]],
                    ],
                ],
            ],
        ];

        foreach ($sections as $section) {
            Section::query()->updateOrCreate(['key' => $section['key']], $section);
        }

        Step::query()->truncate();
        Step::query()->insert([
            [
                'sort' => 1, 'num_label' => 'STEP 01', 'title' => 'Data input',
                'description' => 'Guided prompts make sure nothing is missed.',
                'bullets' => "Dropdowns cover every category of income, expenditure, property, pension and liability\nIn testing, the prompts were what stopped people leaving gaps. One user had overlooked their council tax entirely\nOur software reads your bank transaction descriptions for auto-categorisation, so you are not sorting months of transactions by hand",
                'footnote' => null, 'style' => 'normal', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 2, 'num_label' => 'STEP 02 · THE ENGINE', 'title' => 'Everything auto-populates',
                'description' => 'The court documents are already built into the software. Your inputs flow automatically into every form, Form E, ES1, ES2 and the rest, fully populated and ready to file. No re-keying, no manual drafting.',
                'bullets' => null,
                'footnote' => 'Saves thousands in personal & solicitor time', 'style' => 'highlight', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 3, 'num_label' => 'STEP 03', 'title' => 'Analyse',
                'description' => 'Software first, human expertise on top.',
                'bullets' => "The software reviews the other side's financials and proposes a questionnaire\nYour consultant then reviews it personally, adding what an experienced eye spots that an automated pass would miss",
                'footnote' => null, 'style' => 'normal', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 4, 'num_label' => 'STEP 04', 'title' => 'Negotiate & settle',
                'description' => 'Everything you have entered feeds straight into the settlement engine.',
                'bullets' => "Model different splits and see what each means for both parties\nSet your own settlement zone, the minimum and maximum you would realistically agree to\nSee instantly whether each offer falls inside your range, so you know where you stand before responding",
                'footnote' => 'Your zone is private. You will not see the other party\'s range, and they will not see yours.', 'style' => 'normal', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 5, 'num_label' => 'STEP 05', 'title' => 'See up to the next 15 years',
                'description' => 'A settlement that looks fair today may not stay that way.',
                'bullets' => "Either or both parties can model how the proposed split plays out across the next 15 years\nProjects net wealth and income needs, so you see what you are agreeing to now and the impact it will have later",
                'footnote' => null, 'style' => 'normal', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 6, 'num_label' => 'STEP 06', 'title' => 'Conclude',
                'description' => 'Export your complete and agreed settlement financials, with your full court-ready document set.',
                'bullets' => "Ready for your own drafting if you are representing yourself, or to hand to a solicitor or mediator\n<strong>We do not draft the settlement agreement or consent order.</strong> That is legal drafting and sits outside what we do\nYour solicitor can complete it far more cost effectively, because the financial work is already done and agreed",
                'footnote' => null, 'style' => 'normal', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        PlatformFeature::query()->truncate();
        PlatformFeature::query()->insert([
            [
                'sort' => 1, 'type' => 'lead', 'pip' => 'The USP', 'tag' => 'Settlement engine', 'icon' => null,
                'title' => 'Settlement analysis, scenario modelling & negotiation',
                'description' => 'This is where the whole process is decided. Take every figure you\'ve gathered and reach the agreement itself. Model different splits, see exactly what each one means for both parties, and work through offers and counter-offers in one clear, easy-to-use tool.',
                'bullets' => "Compare split scenarios side by side, instantly\nTrack every offer and counter-offer in one place\nBoth parties negotiate from the same clear numbers",
                'visual' => 'scenarios', 'kicker' => 'Party A &nbsp;·&nbsp; Party B &nbsp;·&nbsp; modelled side by side',
                'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 2, 'type' => 'feature', 'pip' => 'Unique', 'tag' => 'Future planning · AI + human expertise', 'icon' => null,
                'title' => 'See if the settlement is fair not just today, but for years to come',
                'description' => "A court divides the finances as they stand today. It does not show you what that division means for either of you a decade later, and that is where most settlements are quietly won or lost.\n\nBalance Point takes your proposed split and projects it forward across the next 15 years, modelling salary progression, inflation, property values and investment growth to show each party's net wealth and income needs over time. Your consultant then works through the projection with you, testing the assumptions and explaining what the numbers actually mean. Software does the modelling, an experienced financial professional makes sense of it.\n\nWe stop at 15 years by design. It is the right horizon for long-term financial planning, and beyond it projections become too uncertain to be worth relying on.",
                'bullets' => "Takes a settlement-day snapshot out across the next 15 years\nModels salary, inflation, property and investment paths\nReviewed and explained by your consultant, not just generated\nA tool we have not seen offered anywhere else",
                'visual' => 'projection', 'kicker' => 'Projected net wealth, both parties, over time',
                'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 3, 'type' => 'pair', 'pip' => null, 'tag' => 'The prep · 01', 'icon' => 'database',
                'title' => 'Data automation',
                'description' => 'Enter your financials through simple dropdowns and options, and the software collates and structures everything, clearing away the slow, costly groundwork before you ever reach the table.',
                'bullets' => null, 'visual' => null, 'kicker' => null,
                'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 4, 'type' => 'pair', 'pip' => null, 'tag' => 'The prep · 02', 'icon' => 'document',
                'title' => 'Court-form automation',
                'description' => 'Form E, ES1 and ES2 populate directly from your data, plus a proposed questionnaire on the other side\'s disclosure. Hours of form-filling, done in minutes.',
                'bullets' => null, 'visual' => null, 'kicker' => null,
                'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        Tutorial::query()->truncate();
        $tutorials = [
            ['Getting started & your secure portal', 'Set up your account and find your way around Balance Point.', '4:12'],
            ['Entering your financial data', 'Use the guided dropdowns to bring statements, pensions and property in, and let the mapping tool sort your transactions for you.', '6:03'],
            ['Automatic document population', 'Watch Form E, ES1 and ES2 fill themselves from your inputs.', '5:28'],
            ['Document filing', 'Export your documents, check them over properly, and file them yourself or pass them to your solicitor to review and file.', '5:10'],
            ['The disclosure questionnaire', 'Raise a proposed questionnaire on the other side\'s financials, drafted from the data, then reviewed by your consultant.', '5:55'],
            ['Scenario modelling & negotiation', 'Compare different splits, set your settlement zone, and work through offers and counter-offers.', '7:41'],
            ['Future financial planning', 'Model how the proposed settlement plays out across the next 15 years.', '6:20'],
            ['Settlement & completion', 'Pull together your agreed settlement financials and your complete court-ready set.', '4:37'],
        ];
        foreach ($tutorials as $i => [$title, $desc, $dur]) {
            Tutorial::query()->create([
                'sort' => $i + 1, 'title' => $title, 'description' => $desc,
                'duration' => $dur, 'is_locked' => true, 'is_active' => true,
            ]);
        }

        Plan::query()->truncate();
        Plan::query()->insert([
            [
                'sort' => 1, 'slug' => 'tier-1-diy-navigator', 'tier_label' => 'Tier 1',
                'name' => 'DIY Financial Navigator', 'duration_label' => 'Self-guided',
                'price_ind' => 995, 'price_joint' => 1395,
                'sub_ind' => 'Everything you need to run your own case, at your own pace.',
                'sub_joint' => 'Both of you working from the same figures, each with your own private login.',
                'features' => "Full access to the Balance Point software\nYour own secure portal\nComplete video tutorial library",
                'badge' => null, 'featured' => false, 'cta_label' => 'Choose Tier 1', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 2, 'slug' => 'tier-2-standard', 'tier_label' => 'Tier 2 · Standard',
                'name' => 'Financial Divorce Navigator', 'duration_label' => 'Up to 6 months',
                'price_ind' => 2495, 'price_joint' => 3495,
                'sub_ind' => 'Hands-on support for self-negotiation or mediation.',
                'sub_joint' => 'Hands-on support for both parties, with consultancy hours for each of you.',
                'features' => "Everything in Tier 1\nAutomated financial collation\nForm E, ES1 & ES2 automation & support\nFull Balance Point modelling access\n5 hours of consultancy support|5 hours of consultancy support each",
                'badge' => 'Most popular', 'featured' => true, 'cta_label' => 'Choose Tier 2', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 3, 'slug' => 'tier-3-complete', 'tier_label' => 'Tier 3 · Complete',
                'name' => 'Complete Financial Package', 'duration_label' => '6–12 months',
                'price_ind' => 3495, 'price_joint' => 4995,
                'sub_ind' => 'For estates with company, trust or overseas assets.',
                'sub_joint' => 'For both parties where the estate holds company, trust or overseas assets.',
                'features' => "Everything in Tier 2\nExtended 6–12 month case support\n10 hours of consultancy support|10 hours of consultancy support each\nRequired for company, trust or overseas assets",
                'badge' => null, 'featured' => false, 'cta_label' => 'Choose Tier 3', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        Addon::query()->truncate();
        Addon::query()->insert([
            [
                'sort' => 1, 'name' => 'Financial Clarity Session',
                'description' => '90-minute intro consultation: asset mapping and a roadmap for your next steps. If you go on to a package the £295 is discounted from it and the 90 minutes carries forward, so nothing is wasted.',
                'price_ind' => 295, 'price_joint' => 295, 'price_suffix' => 'per session', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 2, 'name' => 'Financial Reality Check',
                'description' => 'Pre-divorce: full data collation, split scenarios & a 90-minute negotiation consultation.',
                'price_ind' => 995, 'price_joint' => 1395, 'price_suffix' => 'ind · joint', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 3, 'name' => 'Additional consultancy',
                'description' => 'Extra one-to-one support, added to any package whenever you need it.',
                'price_ind' => 195, 'price_joint' => 195, 'price_suffix' => 'per hour', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'sort' => 4, 'name' => 'FDR hearing support',
                'description' => 'Live financial modelling of every offer at your Financial Dispute Resolution hearing, where most of the negotiation happens. Your solicitor or barrister handles the negotiating; we make sure the numbers behind every offer are right, in real time. UK mainland only, travel charged at £1 per mile. Strictly no legal advice.',
                'price_ind' => 1200, 'price_joint' => 1200, 'price_suffix' => 'per hearing', 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        Value::query()->truncate();
        Value::query()->insert([
            ['sort' => 1, 'icon' => 'shield', 'title' => 'Your data stays yours', 'description' => 'Encrypted, UK GDPR-compliant, and held in your own secure portal, never a shared inbox.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sort' => 2, 'icon' => 'scales', 'title' => 'Fair by design', 'description' => 'Every scenario shows the outcome for both parties. Nothing hidden, nothing weighted.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sort' => 3, 'icon' => 'clock', 'title' => 'Faster, lower cost', 'description' => 'Automation and clear modelling cut the hours, and the legal fees that come with them.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sort' => 4, 'icon' => 'chart', 'title' => 'Numbers done properly', 'description' => 'Chartered-accountant methodology behind every figure you rely on.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Faq::query()->truncate();
        $faqs = [
            ['How do I get access after I pay?', 'As soon as your payment is confirmed, we create your secure Balance Point account and email you a private link to set your own password. For your security we never send passwords by email. You choose your own the first time you log in.'],
            ['Is my financial data safe?', 'Yes. Your data is encrypted and held in your own secure, UK GDPR-compliant portal. It\'s never stored in a shared inbox or visible to anyone outside your case. You stay in control of it throughout.'],
            ['Do you give financial or legal advice?', 'No. We offer no advice of any kind. Next Chapter is not a law firm and is not authorised or regulated by the FCA. We provide financial modelling, document automation and clarity only. Offering no advice is exactly how we stay impartial and can support both parties in a case without bias. For advice on areas such as pensions, you should consult a suitably qualified regulated adviser.'],
            ['Do both parties have to be on good terms to use a joint package?', 'No. A joint application works even where things are difficult between you. Each party gets their own separate, private login and their own account access, and each of you receives the full consultancy allocation for the tier. Because we take no side and give no advice, we can hold an account for each of you without bias. All that is needed is that you both agree to see the finances in the same clear format. An individual package supports just one party.'],
            ['Can I upgrade later?', 'Yes. You can move up a tier at any point as your case develops. A simple case that turns complex is exactly what upgrading is for. What you\'ve already paid is credited towards the higher package, so you never pay twice for the same thing.'],
            ['Which package is right for me?', 'If you\'re comfortable working independently, Tier 1 gives you the software and the full tutorial library. Tier 2 adds document automation and hands-on consultancy for self-negotiation or mediation. Tier 3 suits complex, business or higher-value estates. Not sure? Start with a £295 Financial Clarity Session. If you go on to a package, the £295 is discounted from it and your session time carries forward, so nothing is wasted.'],
        ];
        foreach ($faqs as $i => [$q, $a]) {
            Faq::query()->create(['sort' => $i + 1, 'question' => $q, 'answer' => $a, 'is_active' => true]);
        }
    }
}
