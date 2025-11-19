<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>رسالة من الموقع</title>
  <style>
    /* عموميات بسيطة لتحسين العرض في معظم عملاء البريد */
    body {
      margin: 0;
      padding: 0;
      background-color: #f4f6f8;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", sans-serif;
      color: #1f2937;
      -webkit-text-size-adjust: 100%;
    }
    a { color: #2563eb; text-decoration: none; }
    .container { width: 100%; max-width: 680px; margin: 0 auto; padding: 24px; }
    .card {
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 18px rgba(16,24,40,0.08);
      border: 1px solid rgba(15,23,42,0.04);
    }
    .card-header {
      padding: 20px 24px;
      background: linear-gradient(90deg,#0ea5e9 0%, #6366f1 100%); /* accent gradient */
      color: white;
      display:flex;
      align-items:center;
      gap:12px;
    }
    .logo {
      width:48px; height:48px; border-radius:8px; background:#fff; display:inline-flex; align-items:center; justify-content:center; overflow:hidden;
    }
    .title { font-size:18px; font-weight:700; }
    .card-body { padding: 20px 24px; }
    .rows { display:flex; gap:12px; margin-bottom:12px; align-items:flex-start; }
    .label { min-width:120px; font-weight:700; color:#374151; }
    .value { background:#f8fafc; padding:10px 12px; border-radius:8px; flex:1; color:#0f172a; }
    .message-box { background:#f8fafc; padding:14px; border-radius:8px; color:#0f172a; line-height:1.6; }
    .cta { display:flex; gap:12px; margin-top:18px; }
    .btn {
      display:inline-block;
      padding:10px 14px;
      border-radius:10px;
      font-weight:700;
      text-decoration:none;
    }
    .btn-primary { background: #6366f1; color: #fff; }
    .btn-ghost { background: transparent; color:#374151; border:1px solid rgba(15,23,42,0.06); }
    .meta { padding: 14px 24px; font-size:13px; color:#6b7280; background: linear-gradient(0deg, rgba(99,102,241,0.03), rgba(99,102,241,0.03)); }
    .footer { padding: 14px 24px; text-align:center; color:#9ca3af; font-size:13px; }

    /* استجابة بسيطة */
    @media (max-width:520px) {
      .rows { flex-direction: column; }
      .label { min-width: auto; }
    }
  </style>
</head>
<body>
  <div class="container" role="article" aria-roledescription="email">
    <div class="card" role="presentation">
      <div class="card-header">
        <div class="logo">
          <!-- ضع هنا صورة الشعار إن رغبت -->
          <img src="{{ $logo ?? asset('/logo.png') }}" alt="{{ $siteName ?? 'المنصة' }}" style="width:100%;height:100%;object-fit:cover;" />
        </div>
        <div style="flex:1">
          <div class="title">رسالة جديدة من نموذج الاتصال</div>
          <div style="font-size:13px; opacity:0.9; margin-top:4px;">
            تم استلام رسالة جديدة عبر موقع {{ $siteName ?? 'المنصة' }}.
          </div>
        </div>
      </div>

      <div class="card-body" dir="rtl">
        {{-- بيانات المرسل --}}
        <div class="rows" aria-label="بيانات المرسل">
          <div class="label">الاسم</div>
          <div class="value">{{ $name ?? 'غير معروف' }}</div>
        </div>

        <div class="rows" aria-label="بريد المرسل">
          <div class="label">البريد الإلكتروني</div>
          <div class="value">
            @if(!empty($email) && $email !== 'غير محدد')
              <a href="mailto:{{ $email }}">{{ $email }}</a>
            @else
              {{ $email ?? 'غير محدد' }}
            @endif
          </div>
        </div>

        <div class="rows" aria-label="هاتف المرسل">
          <div class="label">رقم الهاتف</div>
          <div class="value">{{ $phone_number ?? 'غير محدد' }}</div>
        </div>

        <div class="rows" aria-label="موضوع الرسالة">
          <div class="label">الموضوع</div>
          <div class="value">{{ $subject ?? 'بدون موضوع' }}</div>
        </div>

        {{-- محتوى الرسالة --}}
        <div style="margin-top:14px;">
          <div style="font-weight:700; margin-bottom:8px; color:#111827;">نص الرسالة</div>
          <div class="message-box">
            {!! nl2br(e($messageBody ?? 'لا يوجد محتوى')) !!}
          </div>
        </div>

        {{-- أزرار تنفيذية --}}
        <div class="cta" role="group" aria-label="أزرار">
          {{-- زر فتح لوحة تحكم مثال (يمكن استبداله برابط حقيقي) --}}
          <a class="btn btn-ghost" href="{{ $adminUrl ?? '#' }}" target="_blank" rel="noreferrer">فتح الرسالة في لوحة التحكم</a>
        </div>
      </div>

      <div class="meta">
        تم الاستلام: {{ \Carbon\Carbon::now()->toDayDateTimeString() }}
      </div>

      <div class="footer">
        © {{ date('Y') }} {{ $siteName ?? 'المنصة' }} — جميع الحقوق محفوظة.
      </div>
    </div>
  </div>
</body>
</html>
