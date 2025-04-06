<!DOCTYPE html>
<html lang="en">


<!-- molla/index-2.html  22 Nov 2019 09:55:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FandomEmporium</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('home/assets/images/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('home/assets/images/icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('home/assets/images/icons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('home/assets/images/icons/site.html') }}">
    <link rel="mask-icon" href="{{ asset('home/assets/images/icons/safari-pinned-tab.svg') }}" color="#666666">
    <link rel="shortcut icon" href="{{ asset('home/assets/images/icons/favicon.ico') }}">

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('home/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home/assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('home/assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('home/assets/css/style.css') }}">
    <style>
        /* Star rating styles - comprehensive fix */
        .ratings-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: nowrap;
        }
        
        .ratings {
            position: relative;
            height: 1.4rem;
            margin-right: 1rem;
            min-width: 6.5rem; /* Increased width to ensure 5 stars fit */
            display: inline-block;
            font-size: 0; /* Remove space between characters */
        }
        
        .ratings::before {
            content: "★★★★★"; /* Unicode star character instead of icon font */
            color: #e1e1e1;
            font-size: 1.5rem;
            letter-spacing: 0.05rem; /* Reduced spacing between stars */
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .ratings-val {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            overflow: hidden;
            font-size: 0; /* Remove space between characters */
            white-space: nowrap;
        }
        
        .ratings-val::before {
            content: "★★★★★"; /* Unicode star character instead of icon font */
            color: #fcb941;
            font-size: 1.5rem;
            letter-spacing: 0.05rem; /* Must match the spacing above */
        }
        
        .ratings-text {
            font-size: 1.3rem;
            color: #666;
            padding-left: 0.5rem;
            font-weight: 400;
            min-width: 4.5rem;
            white-space: nowrap;
        }
        
        /* Interactive star rating */
        .stars-container {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }
        
        .star-btn {
            margin-right: 0.8rem; /* Increased spacing between clickable stars */
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
            font-size: 1.8rem;
        }
        
        /* Use star character directly instead of icon font */
        .star-btn.icon-star-o::before {
            content: "★";
            color: #e1e1e1;
        }
        
        .star-btn.icon-star::before {
            content: "★";
            color: #fcb941;
        }
        
        .star-btn:hover {
            color: #fcb941;
        }
        
        /* Product card specific styles */
        .product .ratings-container {
            margin-bottom: 1.2rem;
        }
        
        .product .ratings {
            min-width: 5.5rem;
        }
        
        .product .ratings-text {
            margin-left: 2rem;
        }
        
        /* Review card specific styles */
        .review .ratings-container {
            margin-bottom: 0.5rem;
        }
        
        /* Orders page reviews */
        .recent-review .ratings-container {
            margin-bottom: 0 !important;
        }
        
        .recent-review .ratings-text {
            margin-left: 1.5rem;
        }
        
        /* Review form styles */
        .review-form .stars-container .star-btn {
            font-size: 2rem;
        }
        
        /* Product review card styles */
        .product-review-card {
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .product-review-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Star rating fix - control display of rating value vs stars */
        /* Only show exact star count in specified locations */
        /* 1. In orders page */
        .recent-review .ratings-text {
            content: attr(data-rating) !important;
            display: inline-block !important;
        }
        
        /* 2. Your review tab in review purchases popup */
        #reviewed-products-container .ratings-text,
        /* 3. Individual reviews on reviews section in product page */
        #product-review-tab .review .ratings-text {
            content: attr(data-rating) !important;
            display: inline-block !important;
        }
        
        /* Only show average rating in specified locations */
        /* 1. Product list */
        .products .ratings-text,
        /* 2. Rating below product name of individual product page */
        .product-details .ratings-text {
            /* Already using the default display of average */
        }
        
        /* Modal styles */
        .modal-lg {
            max-width: 900px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">

@include('layouts._header')
@yield('content')
@include('layouts._footer')



    
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>
            
   
            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="{{ route('user.login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="singin-email">Email address *</label>
                                            <input type="email" class="form-control" id="singin-email" name="email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="singin-password">Password *</label>
                                            <input type="password" class="form-control" id="singin-password" name="password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="signin-remember" name="remember">
                                                <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                            </div><!-- End .custom-checkbox -->

                                            <a href="#" class="forgot-link">Forgot Your Password?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    @if(session('error'))
                                    <div class="alert alert-danger mt-3">
                                        {{ session('error') }}
                                    </div>
                                    @endif
                                    @if(session('success'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                </div><!-- .End .tab-pane -->
                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form action="{{ route('user.register') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="register-name">Your name *</label>
                                            <input type="text" class="form-control" id="register-name" name="name" required>
                                        </div><!-- End .form-group -->
                                        
                                        <div class="form-group">
                                            <label for="register-email">Your email address *</label>
                                            <input type="email" class="form-control" id="register-email" name="email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="profile-picture">Profile Picture</label>
                                            <input type="file" class="form-control" id="profile-picture" name="profile_picture" accept="image/*">
                                            <small class="form-text text-muted">Upload a profile picture (optional).</small>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register-password">Password *</label>
                                            <input type="password" class="form-control" id="register-password" name="password" required>
                                        </div><!-- End .form-group -->
                                        
                                        <div class="form-group">
                                            <label for="register-password-confirm">Confirm Password *</label>
                                            <input type="password" class="form-control" id="register-password-confirm" name="password_confirmation" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy" name="agree_terms" required>
                                                <label class="custom-control-label" for="register-policy">I agree to the <a href="#">privacy policy</a> *</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                    @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    <!-- Plugins JS File -->
    <script src="{{ asset('home/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('home/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('home/assets/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ asset('home/assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('home/assets/js/superfish.min.js') }}"></script>
    <script src="{{ asset('home/assets/js/owl.carousel.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('home/assets/js/main.js') }}"></script>
    
    <script>
        // Global function to fix individual star ratings display
        function globalFixStarRatings() {
            // Get the total width of a star (including spacing)
            function getStarWidth(container) {
                const totalWidth = container.width();
                return totalWidth / 5; // 5 stars
            }
            
            // Fix all ratings
            function fixRating(selector, useDataAttr) {
                $(selector).each(function() {
                    const container = $(this).closest('.ratings-container');
                    const ratingContainer = $(this).parent();
                    
                    let rating;
                    if (useDataAttr) {
                        // Use data-rating attribute for exact ratings
                        rating = parseFloat(container.find('.ratings-text').attr('data-rating') || 0);
                    } else {
                        // Use data-width for average ratings (already in percentage)
                        rating = ($(this).data('width') || 0) / 20; // Convert % to 0-5 scale
                    }
                    
                    if (rating > 0) {
                        // For 5-star ratings, ensure they show completely filled
                        if (rating >= 4.9) {
                            $(this).css('width', '100%');
                        } else {
                            // For other ratings, add a small adjustment factor to account for rounding
                            const adjustedRating = rating * 1.03; // Apply a 3% adjustment
                            const totalWidth = ratingContainer.width();
                            // Calculate width in pixels with adjustment
                            const filledWidth = Math.min((adjustedRating / 5) * totalWidth, totalWidth);
                            
                            // Apply calculated width with !important to override any inline styles
                            $(this).css({
                                'width': filledWidth + 'px',
                                'max-width': '100%'
                            });
                        }
                    }
                });
            }
            
            // Fix individual reviews
            fixRating('.review .ratings-val, .recent-review .ratings-val, .product-review-card .ratings-val, .product-review-section .ratings-val', true);
            
            // Fix product list and product details ratings (averages)
            fixRating('.product .ratings-val, .product-details .ratings-val', false);
        }
        
        // Apply on DOM ready
        $(document).ready(function() {
            // Handle form validation errors and modals
            @if(($errors->any() && !session('active_tab')) || session('register_modal'))
                $('#signin-modal').modal('show');
                $('#register-tab').tab('show');
            @endif
            
            @if((session('error') && !session('active_tab')) || session('login_modal'))
                $('#signin-modal').modal('show');
                $('#signin-tab').tab('show');
            @endif
            
            // Fix star ratings with multiple retries to ensure they load correctly
            setTimeout(globalFixStarRatings, 100);
            setTimeout(globalFixStarRatings, 500);
            setTimeout(globalFixStarRatings, 1000);
            
            // Fix after any AJAX completes
            $(document).ajaxComplete(function(event, xhr, settings) {
                setTimeout(globalFixStarRatings, 100);
                setTimeout(globalFixStarRatings, 300);
                
                // If AJAX request involves reviews, initialize review edit controls
                if (settings.url.includes('review')) {
                    setTimeout(function() {
                        // Initialize edit and cancel buttons
                        $('.edit-review-btn').off('click').on('click', function() {
                            const reviewId = $(this).data('review-id');
                            $(`#review-display-${reviewId}`).hide();
                            $(`#review-edit-form-${reviewId}`).show();
                            
                            // Set the current rating
                            const currentRating = $(this).data('current-rating');
                            const starsContainer = $(`#edit-stars-container-${reviewId}`);
                            
                            starsContainer.find('.star-btn').removeClass('icon-star').addClass('icon-star-o');
                            starsContainer.find('.star-btn').each(function() {
                                const starRating = $(this).data('rating');
                                if (starRating <= currentRating) {
                                    $(this).removeClass('icon-star-o').addClass('icon-star');
                                }
                            });
                            
                            $(`#edit-rating-value-${reviewId}`).val(currentRating);
                        });
                        
                        // Cancel editing review
                        $('.cancel-edit-btn').off('click').on('click', function() {
                            const reviewId = $(this).data('review-id');
                            $(`#review-display-${reviewId}`).show();
                            $(`#review-edit-form-${reviewId}`).hide();
                        });
                    }, 100);
                }
            });
            
            // Fix when modals are shown
            $('.modal').on('shown.bs.modal', function() {
                setTimeout(globalFixStarRatings, 100);
                setTimeout(globalFixStarRatings, 300);
            });
            
            // Fix when tabs are shown
            $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
                setTimeout(globalFixStarRatings, 100);
                setTimeout(globalFixStarRatings, 300);
            });
            
            // Fix when images load (which can affect layout)
            $('img').on('load', function() {
                setTimeout(globalFixStarRatings, 100);
            });
            
            // Fix on window resize
            $(window).on('resize', function() {
                setTimeout(globalFixStarRatings, 100);
            });
        });
    </script>
    
    @yield('scripts')
</body>


<!-- molla/index-2.html  22 Nov 2019 09:55:42 GMT -->
</html>