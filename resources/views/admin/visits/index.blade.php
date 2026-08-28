<x-admin-shell title="Site visits">
  <div class="vis-head">
    <div>
      <h1 class="vis-title">Site visits</h1>
      <p class="vis-sub">Every page view on the public site — tracked automatically and reported in real time.</p>
    </div>
    <a href="{{ route('home') }}" target="_blank" class="btn btn-ghost"><x-ad-icon name="external"/>Open live site</a>
  </div>

  <div class="stat-grid">
    <div class="stat">
      <span class="stat-ico"><x-ad-icon name="eye"/></span>
      <div class="stat-body">
        <div class="n">{{ number_format($today) }}</div>
        <div class="l">Visits today</div>
        <div class="s">
          @if($yesterday > 0)
            @php($change = round((($today - $yesterday) / $yesterday) * 100))
            {{ $change >= 0 ? '+' : '' }}{{ $change }}% vs yesterday
          @elseif($today > 0)
            new — no traffic yesterday
          @else
            no traffic yet today
          @endif
        </div>
      </div>
    </div>

    <div class="stat">
      <span class="stat-ico"><x-ad-icon name="login"/></span>
      <div class="stat-body">
        <div class="n">{{ number_format($uniqueToday) }}</div>
        <div class="l">Unique visitors today</div>
        <div class="s">distinct IP addresses</div>
      </div>
    </div>

    <div class="stat">
      <span class="stat-ico"><x-ad-icon name="grid"/></span>
      <div class="stat-body">
        <div class="n">{{ number_format($total) }}</div>
        <div class="l">All-time visits</div>
        <div class="s">since tracking started</div>
      </div>
    </div>

    <div class="stat">
      <span class="stat-ico"><x-ad-icon name="zap"/></span>
      <div class="stat-body">
        <div class="n">{{ number_format(array_sum($series)) }}</div>
        <div class="l">Last {{ count($series) }} days</div>
        <div class="s">@php($top = array_key_last($series) !== null ? $series[array_key_last($series)] : 0) latest {{ ($top) }} today so far</div>
      </div>
    </div>
  </div>

  <div class="vis-row">
    <div class="card vis-chart">
      <h2>Traffic — last {{ count($series) }} days</h2>
      <div class="bar-chart">
        @foreach($series as $date => $value)
          @php($label = \Carbon\CarbonImmutable::createFromFormat('Y-m-d', $date))
          <div class="bar-col">
            <div class="bar-track">
              <div class="bar-fill" style="height:{{ max(2, round(($value / max(1, max($series))) * 100)) }}%"></div>
            </div>
            <div class="bar-n">{{ $value }}</div>
            <div class="bar-l">{{ $label->format('D') }}<small>{{ $label->format('j/n') }}</small></div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="card vis-pages">
      <h2>Top pages <small>· last 30 days</small></h2>
      @if(empty($topPaths))
        <p class="hint">No visits recorded yet.</p>
      @else
        @php($topMax = max(1, max($topPaths)))
        <ul class="tops">
          @foreach($topPaths as $path => $count)
            <li>
              <div class="tops-head">
                <span class="tops-path">/{{ $path }}</span>
                <span class="tops-n">{{ number_format($count) }}</span>
              </div>
              <div class="tops-track"><div class="tops-fill" style="width:{{ round(($count / $topMax) * 100) }}%"></div></div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>

  <div class="card vis-list">
    <h2>Recent visits</h2>
    @if($recent->isEmpty())
      <p class="hint">No visits recorded yet. Open the public site in a browser and views will appear here.</p>
    @else
      <div class="tbl-wrap">
        <table class="tbl">
          <thead>
            <tr>
              <th>When</th>
              <th>Page</th>
              <th>Visitor IP</th>
              <th>Referrer</th>
              <th>Browser</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recent as $visit)
              <tr>
                <td class="nowrap">
                  <span class="v-rel">{{ $visit->visited_at?->diffForHumans() }}</span>
                  <span class="v-abs">{{ $visit->visited_at?->format('M j, Y g:i A') }}</span>
                </td>
                <td><code class="v-path">/{{ $visit->path }}</code></td>
                <td class="mono">{{ $visit->ip ?? '—' }}</td>
                <td class="v-ref">{{ $visit->referer ? \Illuminate\Support\Str::limit($visit->referer, 40) : '—' }}</td>
                <td class="v-ua">{{ \Illuminate\Support\Str::limit($visit->user_agent ?? '—', 45) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $recent->links() }}
    @endif
  </div>
</x-admin-shell>