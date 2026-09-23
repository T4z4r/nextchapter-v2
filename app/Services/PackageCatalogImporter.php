<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class PackageCatalogImporter
{
    /**
     * @return array{created: int, updated: int, skipped: int}
     */
    public function import(?string $url = null): array
    {
        $url ??= config('services.packages.url');

        if (! $url) {
            throw new RuntimeException('PACKAGES_API_URL is not configured.');
        }

        $response = Http::acceptJson()->timeout(15)->get($url);

        if ($response->failed()) {
            throw new RuntimeException('Packages API returned HTTP ' . $response->status() . '.');
        }

        $packages = $response->json('data');

        if (! is_array($packages)) {
            throw new RuntimeException('Packages API response did not contain a data array.');
        }

        $stats = ['created' => 0, 'updated' => 0, 'skipped' => 0];
        $sort = 1;

        foreach ($packages as $package) {
            $data = $this->mapPackage($package, $sort);

            if (! $data) {
                $stats['skipped']++;
                continue;
            }

            $plan = Plan::query()->where('slug', $data['slug'])->first();
            $plan ? $plan->update($data) : Plan::query()->create($data);
            $stats[$plan ? 'updated' : 'created']++;
            $sort++;
        }

        return $stats;
    }

    /**
     * @param array<string, mixed> $package
     * @return array<string, mixed>|null
     */
    private function mapPackage(array $package, int $sort): ?array
    {
        $slug = (string) ($package['slug'] ?? '');
        $name = (string) ($package['name'] ?? '');
        $individual = $package['prices']['individual_gbp'] ?? null;
        $joint = $package['prices']['joint_gbp'] ?? null;

        if ($slug === '' || $name === '' || $individual === null) {
            return null;
        }

        $category = (string) ($package['category'] ?? 'package');
        $features = collect($package['features'] ?? [])
            ->filter(fn ($feature) => is_string($feature) && trim($feature) !== '')
            ->map(fn ($feature) => trim($feature))
            ->implode("\n");

        $summary = collect([
            $package['target_client'] ?? null,
            $package['notes'] ?? null,
        ])->filter()->implode(' ');

        return [
            'sort' => $sort,
            'slug' => $slug,
            'tier_label' => Str::of($category)->replace('_', ' ')->title()->toString(),
            'name' => $name,
            'duration_label' => (string) ($package['duration'] ?? ''),
            'price_ind' => (float) $individual,
            'price_joint' => (float) ($joint ?? $individual),
            'sub_ind' => $summary,
            'sub_joint' => $joint === null ? 'Joint pricing is not available for this package.' : $summary,
            'features' => $features,
            'badge' => null,
            'featured' => $category === 'standard',
            'cta_label' => 'Choose package',
            'is_active' => true,
        ];
    }
}
