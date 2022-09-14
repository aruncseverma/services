<footer>
	<div class="centerwrap">
    	<div class="newsSub">
        	<h4>Want to receive unblocked domains and the latest listings? Subscribe to our newsletter!</h4>
            <div class="newsSBox">
                <form action="{{ route('index.newsletter.subscribe') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="email" name="email" class="newsBox" placeholder="Email address" />                    
                    <button type="submit" class="submitEmail"><i class="far fa-envelope"></i></button>
                </form>
            </div>
        </div>
        <ul class="footerLinks">
            <li><a href="{{ route('index.home') }}" title="ESCORTS">ESCORTS</a></li>
            <li><a href="{{ route('agency.home') }}" title="AGENCIES">AGENCIES</a></li>
            <li><a href="#" title="Blog">BLOG</a></li>
            <li><a href="#">WEBCAM</a></li>
            <li><a href="#" title="FAQ">FAQ</a></li>
            <li><a href="#" title="Contact">CONTACT</a></li>
            <li><a href="{{ route('index.auth.login_form') }}" title="Login">LOGIN</a></li>
            <li><a href="{{ route('index.auth.register') }}" title="Register">REGISTER</a></li>        
        </ul>
        <div class="fLogo"><a href="index.html"><img src="{{ asset('assets/theme/index/default/images/index/logo.png') }}" alt=""/></a></div>
        <div class="footerText">
        	<p>Disclaimer: This website contains adult material, all members and persons appearing on this site have contractually represented to us that they are 18 years of age or older.</p>
			<p>Copyright 2020  ©EscortServices - All Rights Reserved Worldwide.</p>
        </div>
    </div>
</footer>



<!--<footer>
    <div class="newsletter">
        <div class="container">
            <div class="newsletter_left">
                <p>
                    <span class="desktop_only">Want to receive unblocked domains and the latest listings?</span>
                    Subscribe to our newsletter!
                </p>
            </div>
            <div class="newsletter_form">
                <form action="{{ route('index.newsletter.subscribe') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="email" name="email" placeholder="Email address">
                    <button type="submit" title="Sign up!">Sign up!</button>
                </form>
            </div>
        </div>
    </div>

    <div class="main_footer">
        <div class="container">
            <div class="footer_left">
                <a href="#"><img src="{{ asset('assets/theme/index/default/images/index/mainLogo.png') }}" alt="EscortServicesLogo" title="EscortServicesLogo"></a>
            </div>
            <div class="footer_right">
                <div class="f_links">
                    <ul>
                        <li><a href="{{ route('index.home') }}" title="Index">Index</a></li>
                        <li><a href="{{ route('agency.home') }}" title="Agency">Agency</a></li>
                        <li><a href="#" title="Blog">Blog</a></li>
                        <li><a href="#" title="News">News</a></li>
                        <li><a href="#" title="FAQ">FAQ</a></li>
                        <li><a href="#" title="Contact ">Contact</a></li>
                        <li><a href="{{ route('index.auth.login_form') }}" title="Login">Login</a></li>
                        <li><a href="{{ route('index.auth.register') }}" title="Register">Register</a></li>
                    </ul>
                </div>
                <div class="f_copyright">
                    <p>Disclaimer: This website contains adult material, all members and persons appearing on this site have contractually represented to us that they are 18 years of age or older. </p>
                    <p>Copyright 2017 © EscortServices - All Rights Reserved Worldwide.</p>
                </div>
            </div>
        </div>
    </div>
</footer> -->