<?php
$page_url = Request::path();
?>
<div class="col-sm-3 page-sidebar">
    <aside>
        <div class="inner-box">
            <div class="user-panel-sidebar">
                <div class="collapse-box">
                    <div class="panel-collapse collapse in" id="MyClassified">
                        <ul class="acc-list">
                            <li><a class="{{ ($page_url == 'user-panel')? 'active' : '' }}" href="{{ url('user-panel') }}"><i class="icon-home"></i>Dashboard </a></li>
                        </ul>
                    </div>
                </div>

                <div class="collapse-box">
                    <h5 class="collapse-title"> My Ads <a href="#MyAds" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a></h5>
                    <div class="panel-collapse collapse in" id="MyAds">
                        <ul class="acc-list">
                            <li><a class="{{ ($page_url == 'my-ads')? 'active' : '' }}" href="{{ url('my-ads') }}"><i class="icon-docs"></i> My ads <span class="badge">{{ \App\Ads::where(['user_id' => Auth::user()->id])->count() }}</span> </a></li>
                            <li><a class="{{ ($page_url == 'active-ads')? 'active' : '' }}" href="{{ url('active-ads') }}"><i class="icon-folder-close"></i> Active ads <span class="badge total_active">{{ \App\Ads::where(['user_id' => Auth::user()->id, 'status' => 1])->count() }}</span></a></li>
                            <li><a class="{{ ($page_url == 'inactive-ads')? 'active' : '' }}" href="{{ url('inactive-ads') }}"><i class="fa fa-ban"></i> Inactive ads <span class="badge total_inactive">{{ \App\Ads::where(['user_id' => Auth::user()->id, 'status' => 2])->count() }}</span></a></li>
                            <li><a class="{{ ($page_url == 'pending-ads')? 'active' : '' }}" href="{{ url('pending-ads') }}"><i class="icon-clock"></i> Pending approval <span class="badge">{{ \App\Ads::where(['user_id' => Auth::user()->id, 'status' => 0])->count() }}</span></a></li>
                            <li><a class="{{ ($page_url == 'save-ads')? 'active' : '' }}" href="{{ url('save-ads') }}"><i class="fa fa-heart"></i> Saved Ads <span class="badge">{{ \App\SaveAdd::where(['user_id' => Auth::user()->id])->count() }}</span></a></li>
                            <li><a class="{{ ($page_url == 'message')? 'active' : '' }}" href="{{ route('message.index') }}"><i class="fa fa-envelope-o"></i> Message <span class="badge">{{ \App\Message::where(['to' => Auth::user()->id])->count() }}</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>
