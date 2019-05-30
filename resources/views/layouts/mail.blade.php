<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Wampiriada w Łodzi</title>
<style type="text/css">
a:hover { color: #09F !important; text-decoration: underline !important; }
a:hover#vw { background-color: #CCC !important; text-decoration: none !important; color:#000 !important; }
a:hover#ff { background-color: #6CF !important; text-decoration: none !important; color:#FFF !important; }
</style>

{{--

This template requires the following variables:
    $user - an user with email attribute.
    $repository - at least a DatabaseRedirectRepository to gain access to URLs

Optionally you can provide:
    $edition - current edition

--}}

@inject('mailing', 'NZS\Core\Mailing\MailingManager')

@if($mailing->isInPreviewMode())
    <script type="text/javascript" src="{{ url('bower_components/iframe-resizer/js/iframeResizer.contentWindow.min.js') }}"></script>
@endif

</head>
<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #FFFFFF;" bgcolor="#FFFFFF" leftmargin="0">
<!--100% body table-->
<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
    <tr>
        <td>
            <!--email container-->
            <table cellspacing="0" border="0" align="center" cellpadding="0" width="624">
                <tr>
                    <td>
                        @section('header')
                        <table cellspacing="0" border="0" cellpadding="0" width="624" style="margin-top: 40px">
                            <tr>

                                <td style="text-align: center">
                                    <a href="{{ $repository->getRedirect('wampiriada') }}"><img src="http://wampiriada.pl/img/wampi28-mailing-official.jpg" alt="@if(isset($edition))Wampiriada - {{ $edition->number  }}. edycja @else Wampiriada @endif"></a>
                                </td>
                            </tr>
                        </table>

                        <table cellspacing="0" border="0" cellpadding="0" width="624" height="25" style="height: 25px;">
                            <tr><td>&nbsp;</td></tr>
                        </table>
                        @show

                        <!--email content-->
                        <table cellspacing="0" border="0" id="email-content" cellpadding="0" width="624">
                            <tr>
                                <td>
                                    @yield('content')
                                </td>
                            </tr>
                        </table>
                        <!--/email content-->

                        <!--footer -->
                        @section('footer')
                        <table cellspacing="0" border="0" cellpadding="0" width="624" height="25" style="height: 25px;">
                            <tr><td>&nbsp;</td></tr>
                        </table>
                        <table cellspacing="0" border="0" cellpadding="0" width="624">
                            <tr><td>
                                <center><p style="font-size: 12px; letter-spacing: 1px; font-family: Arial, sans-serif; color: #9C9AA0 !important; margin-top: 0; margin-left: 0; margin-bottom: 25px; line-height: 1.4; text-align: center;">
                                Niezależne Zrzeszenie Studentów Regionu Łódzkiego<br>
                                90-231 Łódź, ul. Matejki 21/23<br>
                                e-mail: <a href="mailto:nzs@nzs.lodz.pl">nzs@nzs.lodz.pl</a><br>
                                www: <a href="{{ $repository->getRedirect('nzs') }}">nzs.lodz.pl</a><br>
                                fb: <a href="{{ $repository->getRedirect('facebook-nzs') }}">facebook.com/NZSRegionuLodzkiego</a><br>
                                <small><a href="{{ url('newsletter/remove?email=' . urlencode($user->email)) }}">Jeśli nie chcesz otrzymywać takich informacji, kliknij tutaj</a></small>
                                </p></center>
                            </td></tr>
                        </table>
                        @show
                        <!--/footer -->
                    </td>
                </tr>
            </table>
            <!--/email container-->
        </td>
    </tr>
</table>
<!--/100% body table-->
</body>
</html>
