<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="header-wrap">
            <form class="form-header" action="" method="POST">
                <!-- <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." /> -->
                <!-- <button class="au-btn--submit" type="submit">
                    <i class="zmdi zmdi-search"></i>
                </button> -->
            </form>
            <div class="header-button">
                <div class="noti-wrap">
                </div>
                <div class="account-wrap">
                    <div class="account-item clearfix js-item-menu">
                        <div class="image">
                            <img src="{{asset('images/icon/avatar-06.jpg')}}" alt="John Doe" />
                        </div>
                        <div class="content">
                            <a class="js-acc-btn" href="#">{{!empty(auth()->user()->name) ? auth()->user()->name : ''}}</a>
                        </div>
                        <div class="account-dropdown js-dropdown">
                            <div class="info clearfix">
                                <div class="image">
                                    <a href="#">
                                        <img src="{{asset('images/icon/avatar-06.jpg')}}" alt="John Doe" />
                                    </a>
                                </div>
                                <div class="content">
                                    <h5 class="name">
                                        <a href="#">{{!empty(auth()->user()->name) ? auth()->user()->name : ''}}</a>
                                    </h5>
                                    <span class="email"> {{!empty(auth()->user()->email) ? auth()->user()->email : ''}}</span>
                                </div>
                            </div>
                            <div class="account-dropdown__body">
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-account"></i>Account</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                </div>
                            </div>
                            <div class="account-dropdown__footer">
                                <a href="{{route('logout')}}">
                                    <i class="zmdi zmdi-power"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
