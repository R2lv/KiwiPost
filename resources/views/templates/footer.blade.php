
<section id="footer">
    <div class="footer-overlay">
        <div class="contentWrapper">
            <div class="footer-left-block">
                <div class="info-block">
                    <div class="info-block-title">
                        @lang('pages.footer.addresses.uk.country')
                    </div>
                    <div class="info-content">
                        <div class="info-line">
                            <strong>@lang('pages.footer.city'): </strong> @lang('pages.footer.addresses.uk.city')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.address_1'): </strong> @lang('pages.footer.addresses.uk.address_1')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.address_2'): </strong> @lang('pages.footer.addresses.uk.address_2')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.zip'): </strong> @lang('pages.footer.addresses.uk.zip')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.phone'): </strong> @lang('pages.footer.addresses.uk.phone')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.email'): </strong> @lang('pages.footer.addresses.uk.email')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.web'): </strong> @lang('pages.footer.addresses.uk.web')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.addresses.uk.tue-thu-fri'): </strong> @lang('pages.footer.addresses.uk.twf-hours')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.addresses.uk.w-days'): </strong> @lang('pages.footer.addresses.uk.w-days-hours')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.addresses.uk.free_days'): </strong> @lang('pages.footer.addresses.uk.rest_days')
                        </div>
                    </div>
                </div>
                <div class="info-block" style="margin-right: 10px;">
                    <div class="info-block-title">
                        @lang('pages.footer.addresses.ge.city')
                    </div>
                    <div class="info-content">
                        <div class="info-line">
                            <strong>@lang('pages.footer.city'): </strong> @lang('pages.footer.addresses.ge.city')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.address_1'): </strong> @lang('pages.footer.addresses.ge.address_1')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.address_2'): </strong> @lang('pages.footer.addresses.ge.address_2')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.zip'): </strong> @lang('pages.footer.addresses.ge.zip')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.phone'): </strong> @lang('pages.footer.addresses.ge.phone')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.email'): </strong> @lang('pages.footer.addresses.ge.email')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.web'): </strong> @lang('pages.footer.addresses.ge.web')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.addresses.ge.b-days'): </strong> @lang('pages.footer.addresses.ge.b-days-hours')
                        </div>
                        <div class="info-line">
                            <strong>@lang('pages.footer.addresses.ge.w-days-std'): </strong> @lang('pages.footer.addresses.ge.w-days-std-hours')
                            <br> <strong>@lang('pages.footer.addresses.ge.w-days-sday'): </strong> @lang('pages.footer.addresses.ge.w-days-sday-hours')
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="block-bottom-border"></div>
            </div>
            <div class="footer-center-block">


                <div class="payments" style="margin-bottom: 10px;">
                    <img src="/images/payment-icons.png" alt="" style="vertical-align: middle">
                    <a href="https://paybox.ge" target="_blank"><img src="/images/oppa-logo.png" alt="" style="vertical-align: middle; max-width: 30px;"></a>
                </div>
                <div class="phone-number">
                    @lang('pages.footer.addresses.ge.phone')
                </div>

                <div class="contact-block show-xs">
                    <a href="/contacts"><div class="contact-button">Contact Us</div></a>
                </div>

                <div class="social">
                    <span>Follow Us</span>
                    <a href="https://www.facebook.com/Kiwi-Post-457401257954531/" target="_blank"><img src="/images/fb.png" alt=""></a>
                    {{--<a href="#"><img src="/images/gp.png" alt=""></a>--}}
                    <a href="https://www.instagram.com/kiwipost/" target="_blank"><img src="/images/in.png" alt=""></a>
                    <a href="https://www.youtube.com/channel/UCQU5N7aubUac5GBlikks8TA" target="_blank"><img src="/images/yt.png" alt=""></a>
                    {{--<a href="#"><img src="/images/in.png" alt=""></a>--}}
                </div>


            </div>
            <div class="footer-right-block">

                <div class="info-block">
                    <div class="info-block-title">
                        @lang('defaults.menu')
                    </div>
                    <div class="info-content">
                        <a href="/">@lang('defaults.home')</a>
                        <a href="/faq">@lang('defaults.faqs')</a>
                        <a href="/about" data-target="#how">@lang('defaults.aboutUs')</a>
                        <a href="/news" data-target="#how">@lang('defaults.news')</a>
                        <a href="/contacts">@lang('defaults.contactUs')</a>
{{--                        <a href="/Terms.pdf" target="_blank">@lang('defaults.terms')</a>--}}
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>
        </div>

        <div class="geo upper" style="font-family:roboto; height: 30px; color: #fff; position: absolute;width: 100%;text-align: center; bottom: 2px;">&copy;{{ now()->year }} @lang('pages.all_rights_reserved') |
            <a style="text-decoration: none; color: inherit; text-transform: uppercase" target="_blank" href="@lang('defaults.termsURL')">@lang('defaults.terms')</a></div>
    </div>
</section>

