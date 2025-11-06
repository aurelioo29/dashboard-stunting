<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // ==== STAT CARDS ====
        $total     = Post::count();
        $published = Post::where('is_published', 1)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->count();

        $scheduled = Post::where('is_published', 1)
            ->whereNotNull('published_at')
            ->where('published_at', '>', now())
            ->count();

        $drafts    = Post::where('is_published', 0)->count();

        $cards = compact('total', 'published', 'scheduled', 'drafts');

        // ==== DONUT: KOMPOSISI TYPE ====
        $typeRows   = Post::select('type', DB::raw('COUNT(*) as c'))
            ->groupBy('type')
            ->orderBy('type')
            ->get();

        $typeLabels = $typeRows->pluck('type');
        $typeValues = $typeRows->pluck('c');

        // ==== LINE: PUBLISHED PER DAY (14 HARI) ====
        // Asumsi published_at disimpan JAM LOKAL -> jangan CONVERT_TZ
        $start  = now()->subDays(13)->startOfDay();
        $end    = now();

        $perDay = Post::where('is_published', 1)
            ->whereNotNull('published_at')
            ->whereBetween('published_at', [$start, $end])
            ->selectRaw('DATE(published_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        // Lengkapi label kosong biar garisnya mulus
        $labels = [];
        $values = [];
        for ($i = 0; $i < 14; $i++) {
            $ymd = $start->copy()->addDays($i)->toDateString(); // Y-m-d
            $labels[] = Carbon::parse($ymd)->format('d M');      // 06 Nov
            $values[] = (int) optional($perDay->firstWhere('d', $ymd))->c ?? 0;
        }

        // ==== TOP POSTS ====
        $topPosts = Post::when(
            Schema::hasColumn('posts', 'view_count'),
            fn($q) => $q->orderByDesc('view_count'),
            fn($q) => $q->orderByDesc('published_at')
        )
            ->select(
                'id',
                'title',
                DB::raw(Schema::hasColumn('posts', 'view_count') ? 'view_count' : '0 as view_count')
            )
            ->limit(5)
            ->get();

        return view('dashboard', [
            'cards'      => $cards,
            'typeLabels' => $typeLabels,
            'typeValues' => $typeValues,
            'dayLabels'  => $labels,
            'dayValues'  => $values,
            'topPosts'   => $topPosts,
        ]);
    }
}
