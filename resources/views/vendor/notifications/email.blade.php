@component('mail::message')
<style>
  .lotmatch-header {
    text-align: center;
    margin-bottom: 20px;
  }
  .lotmatch-logo {
    width: 80px;
    margin: 0 auto;
    display: block;
  }
  .lotmatch-title {
    color: #1a4d2e;
    font-size: 24px;
    font-weight: bold;
  }
</style>

<div class="lotmatch-header">
    <img src="{{ url('images/logoLM.png') }}" alt="..." class="lotmatch-logo">
    <div class="lotmatch-title">Welcome to LotMatch!</div>
</div>

---

# Verify Your Email Address

Hi {{ trim($user->first_name . ' ' . $user->last_name) ?: 'there' }},

Thanks for joining **LotMatch** — making real estate exploration effortless. 
Please verify your email to activate your account and start exploring.

@component('mail::button', ['url' => $actionUrl, 'color' => 'success'])
Verify Email
@endcomponent

If you didn’t create an account, no further action is required.

Thanks,<br>
**The LotMatch Team**

---

<small style="color:#999;">
If you’re having trouble clicking the “Verify Email” button, copy and paste the URL below into your web browser:<br>
{{ $displayableActionUrl }}
</small>
@endcomponent