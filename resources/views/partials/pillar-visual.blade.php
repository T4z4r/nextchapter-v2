@if($feature->visual === 'scenarios')
  <div class="scen" aria-hidden="true">
    <div class="bar"><span class="lab">Option A</span><span class="track"><span class="a" style="width:58%"></span><span class="b" style="width:42%"></span></span></div>
    <div class="bar"><span class="lab">Option B</span><span class="track"><span class="a" style="width:50%"></span><span class="b" style="width:50%"></span></span></div>
    <div class="bar"><span class="lab">Option C</span><span class="track"><span class="a" style="width:45%"></span><span class="b" style="width:55%"></span></span></div>
    <div class="cap">{!! $feature->kicker !!}</div>
  </div>
@elseif($feature->visual === 'projection')
  <div class="proj" aria-hidden="true">
    <svg viewBox="0 0 300 160" role="img">
      <line x1="8" y1="140" x2="292" y2="140" stroke="rgba(255,255,255,.2)"/>
      <line x1="8" y1="10" x2="8" y2="140" stroke="rgba(255,255,255,.2)"/>
      <path d="M8 110 C 70 100, 130 96, 180 78 S 260 40, 292 26" fill="none" stroke="#459EDF" stroke-width="2.5"/>
      <path d="M8 118 C 70 116, 140 118, 190 116 S 260 108, 292 96" fill="none" stroke="#6FA8CC" stroke-width="2.5"/>
      <circle cx="292" cy="26" r="4" fill="#459EDF"/><circle cx="292" cy="96" r="4" fill="#6FA8CC"/>
      <text x="12" y="20" fill="#A9CBE0" font-family="Spline Sans Mono" font-size="8">Net wealth</text>
      <text x="250" y="152" fill="#A9CBE0" font-family="Spline Sans Mono" font-size="8">15 yrs</text>
    </svg>
    <div class="cap">{{ $feature->kicker }}</div>
  </div>
@endif
