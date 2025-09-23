@php
    $logo1 = \App\Models\Setting::where('key', 'logo_asin')->first();
    $logo2 = \App\Models\Setting::where('key', 'logo_coop_allem')->first();
    $logo3 = \App\Models\Setting::where('key', 'logo_kfw')->first();
    $contactmail = \App\Models\Setting::where('key', 'contact_email')->first();
    $unfollowlink = \App\Models\Setting::where('key', 'unfollowed_link')->first();
    $phone = \App\Models\Setting::where('key','site_telephone')->first();
    $siteemail = \App\Models\Setting::where('key','site_email')->first();
    $siteadresse = \App\Models\Setting::where('key','site_adresse')->first();

@endphp

    <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENA</title>
</head>

<body
    style="font-family: 'Montserrat', Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; color: #333333;">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0"
       style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

    <tr>
        <td align="center" style="padding: 20px;">


            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="width: 30%; margin-right: 20px"><img width="200px" src="{{asset('logo/logo-ars.png')}}" alt="A.R.S"></td>
                    <td align="left" style="padding-left: 20px"><span style="font-weight: 800; font-size: 23px; padding-right: 20px">Autorité de Régulation du Secteur de la santé (A.R.S)</span></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding: 20px;background-color: #f4f4f4;">
            @yield('body')
        </td>
    </tr>
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="background-color: #009639; height: 10px;"></td>
                    <td style="background-color: #FFD100; height: 10px;"></td>
                    <td style="background-color: #EF3340; height: 10px;"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center"
            style="background-color: #ffffff; color: #666666; padding: 20px; font-size: 14px; font-weight: 400; border-radius: 0 0 8px 8px;">
            <p>CENA, {{$siteadresse->value ?? 'Guinkomey, Cotonou, Littoral'}}</p>
            <p> Tel: {{$phone->value ?? '(229) 0120215329 / 0191163737'}}
            </p>
            <p>E-mail: <a href="mailto:{{ $siteemail->value ?? '' }}"
                          style="color: #0A3764; text-decoration: none; font-weight: 700;">{{ $siteemail->value ?? 'ars@presidence.bj' }}</a></p>
            @if($follow)
                <p><a href="{{ $unfollowlink->value ?? '' }}"
                      style="color: #0A3764; text-decoration: none; font-weight: 700;">{{ $unfollowlink->value ? 'Se désabonner' : '' }}</a></p>
            @endif

        </td>
    </tr>
</table>
</body>

</html>
