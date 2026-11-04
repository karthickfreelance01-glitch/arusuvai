@extends('layouts.web')
@section('title', 'Index')

@section('content')
@include('includes.web.header')
    <div class="page-contain">

        <!-- Main content -->
        <div id="main-content" class="main-content">



            <!-- Block 01: Main slide block-->
            <div class="main-slide block-slider">
                <ul class="biolife-carousel nav-none-on-mobile" data-slick='{"arrows": true, "dots": false, "slidesMargin": 0, "slidesToShow": 1, "infinite": true, "speed": 800}' >
                    <li>
                        <div class="slide-contain slider-opt03__layout01 mode-02 " style="background:#fff">
                            <div class="media"></div>
                            <div class="text-content">
                                
                                <h3 class="second-line">Authentic Tamil Nadu Cuisine</h3>
                                <p class="third-line">
                                    Traditional recipes crafted with fresh ingredients, rich spices, and home-style flavors you’ll love.
                                </p>
                                <p class="buttons">
                                    <a href="{{url('book-now')}}" class="btn btn-bold">Book Now</a>
                                </p>

                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="slide-contain slider-opt03__layout01 mode-02 slide-bgr-02">
                            <div class="media"></div>
                            <div class="text-content">
                                <h3 class="second-line">Classic Kerala Delicacies</h3>
                                <p class="third-line">
                                    Experience the taste of God’s Own Country with coconut-rich, aromatic, and soulful dishes.
                                </p>
                                <p class="buttons">
                                    <a href="{{url('book-now')}}" class="btn btn-bold">Book Now</a>
                                </p>
                              
                                
                            </div>
                        </div>
                    </li>
                    
                </ul>
            </div>

            <!-- Block 02: Grid Banners-->
           <div class="banner-block md-margin-top-74px sm-margin-bottom-120px sm-margin-top-0 xs-margin-top-20px">
                <div class="container">
                    <div class="biolife-banner detail-product biolife-banner__detail-product">
                        <div class="banner-contain">
                            <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                    <div class="media">
                                        <a href="#" class="bn-link"><img src="{{asset('web/assets/images/food-dishes.png')}}" width="647" height="647" alt=""></a>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 md-margin-top-0 sm-margin-top_58px xs-margin-top-0">
                                    <div class="text-content">
                                        <div class="head-info">
                                            <h3 class="text1">Monthly Food Subscription – Healthy, Homely, Hassle-Free</h3>
                                            
                                        </div>
                                        <div class="midle-info">
                                            <p class="pr-desc">We offer a dependable monthly subscription service delivering authentic Tamil Nadu And Kerala food
                                                 tailored to individual and family needs. Our meals are cooked fresh every day, following traditional methods and balanced 
                                                 dietary practices. Whether you prefer mild, spicy, or customized meal plans, we ensure consistency in taste, quality, and portioning.
                                                 Ideal for busy lifestyles, our service combines convenience with the warmth of traditional Tamil home cooking.</p>
                                           
                                        </div>
                                        <div class="bottom-info">
                                            <a href="{{url('book-now')}}" class="btn btn-bold">Book Now</a>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
 @include('includes.web.footer')   
@endsection