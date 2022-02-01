@extends('admin.layout.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('admin_assets/css/custom.css') }}">

    <style>
        .add_more{float: right; margin-bottom: 5px; }
        .parent ul{
            /*display: none;*/
        }
    </style>
    @if(isset($group))

        <script>  var category = true;  </script>
    @else
        <script>  var category = false;  </script>
    @endif
    <?php
    $icon = '';
    if( isset($group) &&  $group->icon != ''){
        $icon = $group->icon;
    }
    ?>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Add Groups</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li> <a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="active">Add Group </li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-xs-12">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card-box">
                    <div class="row">
                        <div class="col-xs-7 bg-white product-listing">
                            <!--   LIST       -->
                            <form id="add_group" method="post" role="form" enctype="multipart/form-data">
                                {{csrf_field()}}
                                @if(isset($group))
                                    <input type="hidden" name="id" value="{{(isset($group) && $group->id!='')? $group->id : '' }}">
                                @endif

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Group Title:</label>
                                                <input type="text" name="title" class="form-control" value="{{ ( isset($group) && $group->title != '')? $group->title: '' }}" id="title" placeholder="Group title" required >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" id="is_icon" value="option1" name="switch" checked>
                                                    <label for="is_icon">Add Icon</label>
                                                </div>
                                                <div class="radio radio-inline">
                                                    <input type="radio" id="is_image" value="option2" name="switch">
                                                    <label for="is_image">Add Image </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="icon-div">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Icons:</label><br>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default" value="" data-toggle="modal" data-target="#iconModal">Add Icons</button>
                                                    <button type="button" id="myicon" class="btn btn-primary {{ ($icon =='')? 'hidden' : '' }}"><?= ($icon !='')? '<i class="'.$icon.'"></i>' : '' ?></button>
                                                    <input type="hidden" name="icon" value="{{ ( isset($group) && $group->icon != '')? $group->icon: '' }}" id="icon_val" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row hidden" id="img-div">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Image Icon:</label>
                                                <input type="file" name="image" class="filestyle" data-input="false">
                                                <img src="" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Category:</label>
                                                <select @if(!isset($group)) name="category_id" @endif id="category" class="form-control" required>
                                                    <option value="">Select category</option>
                                                    @foreach($cat as $value)
                                                        <option <?= ( isset($group) && $group->category_id == $value['id'] )? 'selected': ''; ?> value=" <?= $value['id']; ?>"> <?= $value['name'] ?></option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="c_info"></div>
                                </div>
                            </form>

                            <!-- End list  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modelTitleId">Add Icon</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="form-group search-box">
                                <input type="text" id="search-input" class="form-control product-search" placeholder="Search here...">
                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-boxs">
                        <section>

                            <div class="icon-list-demo row">
                                <div class="col-md-2"><i class="fa fa-american-sign-language-interpreting"></i><span class="hidden">fa-american-sign-language-interpreting</span></div>

                                <div class="col-md-2"><i class="fa fa-asl-interpreting"></i><span class="hidden">fa-asl-interpreting</span></div>

                                <div class="col-md-2"><i class="fa fa-assistive-listening-systems"></i><span class="hidden">fa-assistive-listening-systems</span></div>

                                <div class="col-md-2"><i class="fa fa-audio-description"></i><span class="hidden">fa-audio-description</span></div>

                                <div class="col-md-2"><i class="fa fa-blind"></i><span class="hidden">fa-blind</span></div>

                                <div class="col-md-2"><i class="fa fa-braille"></i><span class="hidden">fa-braille</span></div>

                                <div class="col-md-2"><i class="fa fa-deaf"></i><span class="hidden">fa-deaf</span></div>

                                <div class="col-md-2"><i class="fa fa-deafness"></i><span class="hidden">fa-deafness</span></div>

                                <div class="col-md-2"><i class="fa fa-envira"></i><span class="hidden">fa-envira</span></div>

                                <div class="col-md-2"><i class="fa fa-first-order"></i><span class="hidden">fa-first-order</span></div>

                                <div class="col-md-2"><i class="fa fa-gitlab"></i><span class="hidden">fa-gitlab</span></div>

                                <div class="col-md-2"><i class="fa fa-glide"></i><span class="hidden">fa-glide</span></div>

                                <div class="col-md-2"><i class="fa fa-glide-g"></i><span class="hidden">fa-glide-g</span></div>

                                <div class="col-md-2"><i class="fa fa-hard-of-hearing"></i><span class="hidden">fa-hard-of-hearing</span></div>

                                <div class="col-md-2"><i class="fa fa-low-vision"></i><span class="hidden">fa-low-vision</span></div>

                                <div class="col-md-2"><i class="fa fa-pied-piper"></i><span class="hidden">fa-pied-piper</span></div>

                                <div class="col-md-2"><i class="fa fa-question-circle-o"></i><span class="hidden">fa-question-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-sign-language"></i><span class="hidden">fa-sign-language</span></div>

                                <div class="col-md-2"><i class="fa fa-signing"></i><span class="hidden">fa-signing</span></div>

                                <div class="col-md-2"><i class="fa fa-snapchat"></i><span class="hidden">fa-snapchat</span></div>

                                <div class="col-md-2"><i class="fa fa-snapchat-ghost"></i><span class="hidden">fa-snapchat-ghost</span></div>

                                <div class="col-md-2"><i class="fa fa-snapchat-square"></i><span class="hidden">fa-snapchat-square</span></div>

                                <div class="col-md-2"><i class="fa fa-themeisle"></i><span class="hidden">fa-themeisle</span></div>

                                <div class="col-md-2"><i class="fa fa-universal-access"></i><span class="hidden">fa-universal-access</span></div>

                                <div class="col-md-2"><i class="fa fa-viadeo"></i><span class="hidden">fa-viadeo</span></div>

                                <div class="col-md-2"><i class="fa fa-viadeo-square"></i><span class="hidden">fa-viadeo-square</span></div>

                                <div class="col-md-2"><i class="fa fa-volume-control-phone"></i><span class="hidden">fa-volume-control-phone</span></div>

                                <div class="col-md-2"><i class="fa fa-wheelchair-alt"></i><span class="hidden">fa-wheelchair-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-wpbeginner"></i><span class="hidden">fa-wpbeginner</span></div>

                                <div class="col-md-2"><i class="fa fa-wpforms"></i><span class="hidden">fa-wpforms</span></div>

                                <div class="col-md-2"><i class="fa fa-yoast"></i><span class="hidden">fa-yoast</span></div>

                                <div class="col-md-2"><i class="fa fa-font-awesome"></i></div>

                                <div class="col-md-2"><i class="fa fa-font-awesome"></i><span class="hidden">fa-font-awesome</span></div>

                                <div class="col-md-2"><i class="fa fa-google-plus-official"></i><span class="hidden">fa-google-plus-official</span></div>

                            </div>
                        </section>

                        <section>

                            <div class="icon-list-demo row">
                                <div class="col-md-2"><i class="fa fa-bluetooth"></i><span class="hidden">fa-bluetooth</span></div>

                                <div class="col-md-2"><i class="fa fa-bluetooth-b"></i><span class="hidden">fa-bluetooth-b</span></div>

                                <div class="col-md-2"><i class="fa fa-codiepie"></i><span class="hidden">fa-codiepie</span></div>

                                <div class="col-md-2"><i class="fa fa-credit-card-alt"></i><span class="hidden">fa-credit-card-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-edge"></i><span class="hidden">fa-edge</span></div>

                                <div class="col-md-2"><i class="fa fa-fort-awesome"></i><span class="hidden">fa-fort-awesome</span></div>

                                <div class="col-md-2"><i class="fa fa-hashtag"></i><span class="hidden">fa-hashtag</span></div>

                                <div class="col-md-2"><i class="fa fa-mixcloud"></i><span class="hidden">fa-mixcloud</span></div>

                                <div class="col-md-2"><i class="fa fa-modx"></i><span class="hidden">fa-modx</span></div>

                                <div class="col-md-2"><i class="fa fa-pause-circle"></i><span class="hidden">fa-pause-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-pause-circle-o"></i><span class="hidden">fa-pause-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-percent"></i><span class="hidden">fa-percent</span></div>

                                <div class="col-md-2"><i class="fa fa-product-hunt"></i><span class="hidden">fa-product-hunt</span></div>

                                <div class="col-md-2"><i class="fa fa-reddit-alien"></i><span class="hidden">fa-reddit-alien</span></div>

                                <div class="col-md-2"><i class="fa fa-scribd"></i><span class="hidden">fa-scribd</span></div>

                                <div class="col-md-2"><i class="fa fa-shopping-bag"></i><span class="hidden">fa-shopping-bag</span></div>

                                <div class="col-md-2"><i class="fa fa-shopping-basket"></i><span class="hidden">fa-shopping-basket</span></div>

                                <div class="col-md-2"><i class="fa fa-stop-circle"></i><span class="hidden">fa-stop-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-stop-circle-o"></i><span class="hidden">fa-stop-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-usb"></i><span class="hidden">fa-usb</span></div>

                            </div>
                        </section>

                        <section>

                            <div class="icon-list-demo row">
                                <div class="col-md-2"><i class="fa fa-500px"></i><span class="hidden">fa-500px</span></div>

                                <div class="col-md-2"><i class="fa fa-amazon"></i><span class="hidden">fa-amazon</span></div>

                                <div class="col-md-2"><i class="fa fa-balance-scale"></i><span class="hidden">fa-balance-scale</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-0"></i><span class="hidden">fa-battery-0</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-1"></i><span class="hidden">fa-battery-1</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-2"></i><span class="hidden">fa-battery-2</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-3"></i><span class="hidden">fa-battery-3</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-4"></i><span class="hidden">fa-battery-4</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-empty"></i><span class="hidden">fa-battery-empty</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-full"></i><span class="hidden">fa-battery-full</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-half"></i><span class="hidden">fa-battery-half</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-quarter"></i><span class="hidden">fa-battery-quarter</span></div>

                                <div class="col-md-2"><i class="fa fa-battery-three-quarters"></i><span class="hidden">fa-battery-three-quarters</span></div>

                                <div class="col-md-2"><i class="fa fa-black-tie"></i><span class="hidden">fa-black-tie</span></div>

                                <div class="col-md-2"><i class="fa fa-calendar-check-o"></i><span class="hidden">fa-calendar-check-o</span></div>

                                <div class="col-md-2"><i class="fa fa-calendar-minus-o"></i><span class="hidden">fa-calendar-minus-o</span></div>

                                <div class="col-md-2"><i class="fa fa-calendar-plus-o"></i><span class="hidden">fa-calendar-plus-o</span></div>

                                <div class="col-md-2"><i class="fa fa-calendar-times-o"></i><span class="hidden">fa-calendar-times-o</span></div>

                                <div class="col-md-2"><i class="fa fa-cc-diners-club"></i><span class="hidden">fa-cc-diners-club</span></div>

                                <div class="col-md-2"><i class="fa fa-cc-jcb"></i><span class="hidden">fa-cc-jcb</span></div>

                                <div class="col-md-2"><i class="fa fa-chrome"></i><span class="hidden">fa-chrome</span></div>

                                <div class="col-md-2"><i class="fa fa-clone"></i><span class="hidden">fa-clone</span></div>

                                <div class="col-md-2"><i class="fa fa-commenting"></i><span class="hidden">fa-commenting</span></div>

                                <div class="col-md-2"><i class="fa fa-commenting-o"></i><span class="hidden">fa-commenting-o</span></div>

                                <div class="col-md-2"><i class="fa fa-contao"></i><span class="hidden">fa-contao</span></div>

                                <div class="col-md-2"><i class="fa fa-creative-commons"></i><span class="hidden">fa-creative-commons</span></div>

                                <div class="col-md-2"><i class="fa fa-expeditedssl"></i><span class="hidden">fa-expeditedssl</span></div>

                                <div class="col-md-2"><i class="fa fa-firefox"></i><span class="hidden">fa-firefox</span></div>

                                <div class="col-md-2"><i class="fa fa-fonticons"></i><span class="hidden">fa-fonticons</span></div>

                                <div class="col-md-2"><i class="fa fa-genderless"></i><span class="hidden">fa-genderless</span></div>

                                <div class="col-md-2"><i class="fa fa-get-pocket"></i><span class="hidden">fa-get-pocket</span></div>

                                <div class="col-md-2"><i class="fa fa-gg"></i><span class="hidden">fa-gg</span></div>

                                <div class="col-md-2"><i class="fa fa-gg-circle"></i><span class="hidden">fa-gg-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-grab-o"></i><span class="hidden">fa-hand-grab-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-lizard-o"></i><span class="hidden">fa-hand-lizard-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-paper-o"></i><span class="hidden">fa-hand-paper-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-peace-o"></i><span class="hidden">fa-hand-peace-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-pointer-o"></i><span class="hidden">fa-hand-pointer-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-rock-o"></i><span class="hidden">fa-hand-rock-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-scissors-o"></i><span class="hidden">fa-hand-scissors-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-spock-o"></i><span class="hidden">fa-hand-spock-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-stop-o"></i><span class="hidden">fa-hand-stop-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hourglass"></i><span class="hidden">fa-hourglass</span></div>

                                <div class="col-md-2"><i class="fa fa-hourglass-1"></i><span class="hidden">fa-hourglass-1</span></div>

                                <div class="col-md-2"><i class="fa fa-hourglass-2"></i><span class="hidden">fa-hourglass-2</span></div>

                                <div class="col-md-2"><i class="fa fa-hourglass-3"></i><span class="hidden">fa-hourglass-3</span></div>

                                <div class="col-md-2"><i class="fa fa-hourglass-end"></i><span class="hidden">fa-hourglass-end</span></div>

                                <div class="col-md-2"><i class="fa fa-hourglass-half"></i><span class="hidden">fa-hourglass-half</span></div>

                                <div class="col-md-2"><i class="fa fa-hourglass-o"></i><span class="hidden">fa-hourglass-o</span></div>

                                <div class="col-md-2"><i class="fa fa-hourglass-start"></i><span class="hidden">fa-hourglass-start</span></div>

                                <div class="col-md-2"><i class="fa fa-houzz"></i><span class="hidden">fa-houzz</span></div>

                                <div class="col-md-2"><i class="fa fa-i-cursor"></i><span class="hidden">fa-i-cursor</span></div>

                                <div class="col-md-2"><i class="fa fa-industry"></i><span class="hidden">fa-industry</span></div>

                                <div class="col-md-2"><i class="fa fa-internet-explorer"></i><span class="hidden">fa-internet-explorer</span></div>

                                <div class="col-md-2"><i class="fa fa-map"></i><span class="hidden">fa-map</span></div>

                                <div class="col-md-2"><i class="fa fa-map-o"></i><span class="hidden">fa-map-o</span></div>

                                <div class="col-md-2"><i class="fa fa-map-pin"></i><span class="hidden">fa-map-pin</span></div>

                                <div class="col-md-2"><i class="fa fa-map-signs"></i><span class="hidden">fa-map-signs</span></div>

                                <div class="col-md-2"><i class="fa fa-mouse-pointer"></i><span class="hidden">fa-mouse-pointer</span></div>

                                <div class="col-md-2"><i class="fa fa-object-group"></i><span class="hidden">fa-object-group</span></div>

                                <div class="col-md-2"><i class="fa fa-object-ungroup"></i><span class="hidden">fa-object-ungroup</span></div>

                                <div class="col-md-2"><i class="fa fa-odnoklassniki"></i><span class="hidden">fa-odnoklassniki</span></div>

                                <div class="col-md-2"><i class="fa fa-odnoklassniki-square"></i><span class="hidden">fa-odnoklassniki-square</span></div>

                                <div class="col-md-2"><i class="fa fa-opencart"></i><span class="hidden">fa-opencart</span></div>

                                <div class="col-md-2"><i class="fa fa-opera"></i><span class="hidden">fa-opera</span></div>

                                <div class="col-md-2"><i class="fa fa-optin-monster"></i><span class="hidden">fa-optin-monster</span></div>

                                <div class="col-md-2"><i class="fa fa-registered"></i><span class="hidden">fa-registered</span></div>

                                <div class="col-md-2"><i class="fa fa-safari"></i><span class="hidden">fa-safari</span></div>

                                <div class="col-md-2"><i class="fa fa-sticky-note"></i><span class="hidden">fa-sticky-note</span></div>

                                <div class="col-md-2"><i class="fa fa-sticky-note-o"></i><span class="hidden">fa-sticky-note-o</span></div>

                                <div class="col-md-2"><i class="fa fa-television"></i><span class="hidden">fa-television</span></div>

                                <div class="col-md-2"><i class="fa fa-trademark"></i><span class="hidden">fa-trademark</span></div>

                                <div class="col-md-2"><i class="fa fa-tripadvisor"></i><span class="hidden">fa-tripadvisor</span></div>

                                <div class="col-md-2"><i class="fa fa-tv"></i><span class="hidden">fa-tv</span></div>

                                <div class="col-md-2"><i class="fa fa-vimeo"></i><span class="hidden">fa-vimeo</span></div>

                                <div class="col-md-2"><i class="fa fa-wikipedia-w"></i><span class="hidden">fa-wikipedia-w</span></div>

                                <div class="col-md-2"><i class="fa fa-y-combinator"></i><span class="hidden">fa-y-combinator</span></div>

                                <div class="col-md-2"><i class="fa fa-yc"></i><span class="hidden">fa-yc</span></div>

                            </div>
                        </section>

                        <section>


                            <div class="icon-list-demo row">
                                <div class="col-md-2"><i class="fa fa-bed"></i><span class="hidden"> fa-bed</span></div>

                                <div class="col-md-2"><i class="fa fa-buysellads"></i><span class="hidden"> fa-buysellads</span></div>

                                <div class="col-md-2"><i class="fa fa-cart-arrow-down"></i><span class="hidden"> fa-cart-arrow-down</span></div>

                                <div class="col-md-2"><i class="fa fa-cart-plus"></i><span class="hidden"> fa-cart-plus</span></div>

                                <div class="col-md-2"><i class="fa fa-connectdevelop"></i><span class="hidden"> fa-connectdevelop</span></div>

                                <div class="col-md-2"><i class="fa fa-dashcube"></i><span class="hidden"> fa-dashcube</span></div>

                                <div class="col-md-2"><i class="fa fa-diamond"></i><span class="hidden"> fa-diamond</span></div>

                                <div class="col-md-2"><i class="fa fa-facebook-official"></i><span class="hidden"> fa-facebook-official</span></div>

                                <div class="col-md-2"><i class="fa fa-forumbee "></i><span class="hidden"> fa-forumbee </span></div>

                                <div class="col-md-2"><i class="fa fa-heartbeat"></i><span class="hidden"> fa-heartbeat</span></div>

                                <div class="col-md-2"><i class="fa fa-bed"></i><span class="hidden"> fa-bed</span></div>

                                <div class="col-md-2"><i class="fa fa-leanpub"></i><span class="hidden"> fa-leanpub</span></div>

                                <div class="col-md-2"><i class="fa fa-mars"></i><span class="hidden"> fa-mars</span></div>

                                <div class="col-md-2"><i class="fa fa-mars-double"></i><span class="hidden"> fa-mars-double</span></div>

                                <div class="col-md-2"><i class="fa fa-mars-stroke"></i><span class="hidden"> fa-mars-stroke</span></div>

                                <div class="col-md-2"><i class="fa fa-mars-stroke-h "></i><span class="hidden"> fa-mars-stroke-h </span></div>

                                <div class="col-md-2"><i class="fa fa-mars-stroke-v"></i><span class="hidden"> fa-mars-stroke-v</span></div>

                                <div class="col-md-2"><i class="fa fa-medium "></i><span class="hidden"> fa-medium </span></div>

                                <div class="col-md-2"><i class="fa fa-mercury"></i><span class="hidden"> fa-mercury</span></div>

                                <div class="col-md-2"><i class="fa fa-motorcycle"></i><span class="hidden"> fa-motorcycle</span></div>

                                <div class="col-md-2"><i class="fa fa-neuter "></i><span class="hidden"> fa-neuter </span></div>

                                <div class="col-md-2"><i class="fa fa-pinterest-p "></i><span class="hidden"> fa-pinterest-p </span></div>

                                <div class="col-md-2"><i class="fa fa-sellsy"></i><span class="hidden"> fa-sellsy</span></div>

                                <div class="col-md-2"><i class="fa fa-server"></i><span class="hidden"> fa-server</span></div>

                                <div class="col-md-2"><i class="fa fa-ship"></i><span class="hidden"> fa-ship</span></div>

                                <div class="col-md-2"><i class="fa fa-shirtsinbulk"></i><span class="hidden"> fa-shirtsinbulk</span></div>

                                <div class="col-md-2"><i class="fa fa-simplybuilt"></i><span class="hidden"> fa-simplybuilt</span></div>

                                <div class="col-md-2"><i class="fa fa-skyatlas"></i><span class="hidden"> fa-skyatlas</span></div>

                                <div class="col-md-2"><i class="fa fa-street-view"></i><span class="hidden"> fa-street-view</span></div>

                                <div class="col-md-2"><i class="fa fa-subway"></i><span class="hidden"> fa-subway</span></div>

                                <div class="col-md-2"><i class="fa fa-train"></i><span class="hidden"> fa-train</span></div>

                                <div class="col-md-2"><i class="fa fa-transgender"></i><span class="hidden"> fa-transgender</span></div>

                                <div class="col-md-2"><i class="fa fa-transgender-alt "></i><span class="hidden"> fa-transgend</span>er-alt
                                </div>

                                <div class="col-md-2"><i class="fa fa-user-plus"></i><span class="hidden"> fa-use</span>r-plus
                                </div>

                                <div class="col-md-2"><i class="fa fa-user-secret"></i><span class="hidden"> fa-user-secret</span></div>

                                <div class="col-md-2"><i class="fa fa-user-times"></i><span class="hidden"> fa-user</span>-times
                                </div>

                                <div class="col-md-2"><i class="fa fa-venus"></i><span class="hidden"> fa-venus</span></div>

                                <div class="col-md-2"><i class="fa fa-venus-double"></i><span class="hidden"> fa-venus-double</span></div>

                                <div class="col-md-2"><i class="fa fa-venus-mars "></i><span class="hidden"> fa-venus-mars </span></div>

                                <div class="col-md-2"><i class="fa fa-viacoin"></i><span class="hidden"> fa-viacoin</span></div>

                                <div class="col-md-2"><i class="fa fa-whatsapp"></i><span class="hidden"> fa-whatsapp</span></div>


                            </div>
                        </section>

                        <section id="new-icons">

                            <div class="icon-list-demo row">
                                <div class="col-md-2"><i class="fa fa-angellist"></i><span class="hidden"> fa-angellist</span></div>

                                <div class="col-md-2"><i class="fa fa-area-chart"></i><span class="hidden"> fa-area-chart</span></div>

                                <div class="col-md-2"><i class="fa fa-at"></i><span class="hidden"> fa-at</span></div>

                                <div class="col-md-2"><i class="fa fa-bell-slash"></i><span class="hidden"> fa-bell-slash</span></div>

                                <div class="col-md-2"><i class="fa fa-bell-slash-o"></i><span class="hidden"> fa-bell-slash-o</span></div>

                                <div class="col-md-2"><i class="fa fa-bicycle"></i><span class="hidden"> fa-bicycle</span></div>

                                <div class="col-md-2"><i class="fa fa-binoculars"></i><span class="hidden"> fa-binoculars</span></div>

                                <div class="col-md-2"><i class="fa fa-birthday-cake"></i><span class="hidden"> fa-birthday-cake</span></div>

                                <div class="col-md-2"><i class="fa fa-bus"></i><span class="hidden"> fa-bus</span></div>

                                <div class="col-md-2"><i class="fa fa-calculator"></i><span class="hidden"> fa-calculator</span></div>

                                <div class="col-md-2"><i class="fa fa-cc"></i><span class="hidden"> fa-cc</span></div>

                                <div class="col-md-2"><i class="fa fa-cc-amex"></i><span class="hidden"> fa-cc-amex</span></div>

                                <div class="col-md-2"><i class="fa fa-cc-discover"></i><span class="hidden"> fa-cc-discover</span></div>

                                <div class="col-md-2"><i class="fa fa-cc-mastercard"></i><span class="hidden"> fa-cc-mastercard</span></div>

                                <div class="col-md-2"><i class="fa fa-cc-paypal"></i><span class="hidden"> fa-cc-paypal</span></div>

                                <div class="col-md-2"><i class="fa fa-cc-stripe"></i><span class="hidden"> fa-cc-stripe</span></div>

                                <div class="col-md-2"><i class="fa fa-cc-visa"></i><span class="hidden"> fa-cc-visa</span></div>

                                <div class="col-md-2"><i class="fa fa-copyright"></i><span class="hidden"> fa-copyright</span></div>

                                <div class="col-md-2"><i class="fa fa-eyedropper"></i><span class="hidden"> fa-eyedropper</span></div>

                                <div class="col-md-2"><i class="fa fa-futbol-o"></i><span class="hidden"> fa-futbol-o</span></div>

                                <div class="col-md-2"><i class="fa fa-google-wallet"></i><span class="hidden"> fa-google-wallet</span></div>

                                <div class="col-md-2"><i class="fa fa-ils"></i><span class="hidden"> fa-ils</span></div>

                                <div class="col-md-2"><i class="fa fa-ioxhost"></i><span class="hidden"> fa-ioxhost</span></div>

                                <div class="col-md-2"><i class="fa fa-lastfm"></i><span class="hidden"> fa-lastfm</span></div>

                                <div class="col-md-2"><i class="fa fa-lastfm-square"></i><span class="hidden"> fa-lastfm-square</span></div>

                                <div class="col-md-2"><i class="fa fa-line-chart"></i><span class="hidden"> fa-line-chart</span></div>

                                <div class="col-md-2"><i class="fa fa-meanpath"></i><span class="hidden"> fa-meanpath</span></div>

                                <div class="col-md-2"><i class="fa fa-newspaper-o"></i><span class="hidden"> fa-newspaper-o</span></div>

                                <div class="col-md-2"><i class="fa fa-paint-brush"></i><span class="hidden"> fa-paint-brush</span></div>

                                <div class="col-md-2"><i class="fa fa-paypal"></i><span class="hidden"> fa-paypal</span></div>

                                <div class="col-md-2"><i class="fa fa-pie-chart"></i><span class="hidden"> fa-pie-chart</span></div>

                                <div class="col-md-2"><i class="fa fa-plug"></i><span class="hidden"> fa-plug</span></div>

                                <div class="col-md-2"><i class="fa fa-shekel"></i><span class="hidden"> fa-shekel </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-sheqel"></i><span class="hidden"> fa-sheqel </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-slideshare"></i><span class="hidden"> fa-slideshare</span></div>

                                <div class="col-md-2"><i class="fa fa-soccer-ball-o"></i><span class="hidden"> fa-soccer-ball-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-toggle-off"></i><span class="hidden"> fa-toggle-off</span></div>

                                <div class="col-md-2"><i class="fa fa-toggle-on"></i><span class="hidden"> fa-toggle-on</span></div>

                                <div class="col-md-2"><i class="fa fa-trash"></i><span class="hidden"> fa-trash</span></div>

                                <div class="col-md-2"><i class="fa fa-tty"></i><span class="hidden"> fa-tty</span></div>

                                <div class="col-md-2"><i class="fa fa-twitch"></i><span class="hidden"> fa-twitch</span></div>

                                <div class="col-md-2"><i class="fa fa-wifi"></i><span class="hidden"> fa-wifi</span></div>

                                <div class="col-md-2"><i class="fa fa-yelp"></i><span class="hidden"> fa-yelp</span></div>


                            </div>
                        </section>
                        <section id="web-application">

                            <div class="icon-list-demo row">
                                <div class="col-md-2"><i class="fa fa-adjust"></i><span class="hidden"> fa-adjust</span></div>
                                <div class="col-md-2"><i class="fa fa-anchor"></i><span class="hidden"> fa-anchor</span></div>
                                <div class="col-md-2"><i class="fa fa-archive"></i><span class="hidden"> fa-archive</span></div>

                                <div class="col-md-2"><i class="fa fa-arrows"></i><span class="hidden"> fa-arrows</span></div>

                                <div class="col-md-2"><i class="fa fa-arrows-h"></i><span class="hidden"> fa-arrows-h</span></div>

                                <div class="col-md-2"><i class="fa fa-arrows-v"></i><span class="hidden"> fa-arrows-v</span></div>

                                <div class="col-md-2"><i class="fa fa-asterisk"></i><span class="hidden"> fa-asterisk</span></div>

                                <div class="col-md-2"><i class="fa fa-automobile"></i><span class="hidden"> fa-automobile </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-ban"></i><span class="hidden"> fa-ban</span></div>

                                <div class="col-md-2"><i class="fa fa-bank"></i><span class="hidden"> fa-bank </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-bar-chart-o"></i><span class="hidden"> fa-bar-chart-o</span></div>

                                <div class="col-md-2"><i class="fa fa-barcode"></i><span class="hidden"> fa-barcode</span></div>

                                <div class="col-md-2"><i class="fa fa-bars"></i><span class="hidden"> fa-bars</span></div>

                                <div class="col-md-2"><i class="fa fa-beer"></i><span class="hidden"> fa-beer</span></div>

                                <div class="col-md-2"><i class="fa fa-bell"></i><span class="hidden"> fa-bell</span></div>

                                <div class="col-md-2"><i class="fa fa-bell-o"></i><span class="hidden"> fa-bell-o</span></div>

                                <div class="col-md-2"><i class="fa fa-bolt"></i><span class="hidden"> fa-bolt</span></div>

                                <div class="col-md-2"><i class="fa fa-bomb"></i><span class="hidden"> fa-bomb</span></div>

                                <div class="col-md-2"><i class="fa fa-book"></i><span class="hidden"> fa-book</span></div>

                                <div class="col-md-2"><i class="fa fa-bookmark"></i><span class="hidden"> fa-bookmark</span></div>

                                <div class="col-md-2"><i class="fa fa-bookmark-o"></i><span class="hidden"> fa-bookmark-o</span></div>

                                <div class="col-md-2"><i class="fa fa-briefcase"></i><span class="hidden"> fa-briefcase</span></div>

                                <div class="col-md-2"><i class="fa fa-bug"></i><span class="hidden"> fa-bug</span></div>

                                <div class="col-md-2"><i class="fa fa-building"></i><span class="hidden"> fa-building</span></div>

                                <div class="col-md-2"><i class="fa fa-building-o"></i><span class="hidden"> fa-building-o</span></div>

                                <div class="col-md-2"><i class="fa fa-bullhorn"></i><span class="hidden"> fa-bullhorn</span></div>

                                <div class="col-md-2"><i class="fa fa-bullseye"></i><span class="hidden"> fa-bullseye</span></div>

                                <div class="col-md-2"><i class="fa fa-cab"></i><span class="hidden"> fa-cab</span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-calendar"></i><span class="hidden"> fa-calendar</span></div>

                                <div class="col-md-2"><i class="fa fa-calendar-o"></i><span class="hidden"> fa-calendar-o</span></div>

                                <div class="col-md-2"><i class="fa fa-camera"></i><span class="hidden"> fa-camera</span></div>

                                <div class="col-md-2"><i class="fa fa-camera-retro"></i><span class="hidden"> fa-camera-retro</span></div>

                                <div class="col-md-2"><i class="fa fa-car"></i><span class="hidden"> fa-car</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-square-o-down"></i><span class="hidden"> fa-caret-square-o-down</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-square-o-left"></i><span class="hidden"> fa-caret-square-o-left</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-square-o-right"></i><span class="hidden"> fa-caret-square-o-right</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-square-o-up"></i><span class="hidden"> fa-caret-square-o-up</span></div>

                                <div class="col-md-2"><i class="fa fa-certificate"></i><span class="hidden"> fa-certificate</span></div>

                                <div class="col-md-2"><i class="fa fa-check"></i><span class="hidden"> fa-check</span></div>

                                <div class="col-md-2"><i class="fa fa-check-circle"></i><span class="hidden"> fa-check-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-check-circle-o"></i><span class="hidden"> fa-check-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-check-square"></i><span class="hidden"> fa-check-square</span></div>

                                <div class="col-md-2"><i class="fa fa-check-square-o"></i><span class="hidden"> fa-check-square-o</span></div>

                                <div class="col-md-2"><i class="fa fa-child"></i><span class="hidden"> fa-child</span></div>

                                <div class="col-md-2"><i class="fa fa-circle"></i><span class="hidden"> fa-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-circle-o"></i><span class="hidden"> fa-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-circle-o-notch"></i><span class="hidden"> fa-circle-o-notch</span></div>

                                <div class="col-md-2"><i class="fa fa-circle-thin"></i><span class="hidden"> fa-circle-thin</span></div>

                                <div class="col-md-2"><i class="fa fa-clock-o"></i><span class="hidden"> fa-clock-o</span></div>

                                <div class="col-md-2"><i class="fa fa-cloud"></i><span class="hidden"> fa-cloud</span></div>

                                <div class="col-md-2"><i class="fa fa-cloud-download"></i><span class="hidden"> fa-cloud-download</span></div>

                                <div class="col-md-2"><i class="fa fa-cloud-upload"></i><span class="hidden"> fa-cloud-upload</span></div>

                                <div class="col-md-2"><i class="fa fa-code"></i><span class="hidden"> fa-code</span></div>

                                <div class="col-md-2"><i class="fa fa-code-fork"></i><span class="hidden"> fa-code-fork</span></div>

                                <div class="col-md-2"><i class="fa fa-coffee"></i><span class="hidden"> fa-coffee</span></div>

                                <div class="col-md-2"><i class="fa fa-cog"></i><span class="hidden"> fa-cog</span></div>

                                <div class="col-md-2"><i class="fa fa-cogs"></i><span class="hidden"> fa-cogs</span></div>

                                <div class="col-md-2"><i class="fa fa-comment"></i><span class="hidden"> fa-comment</span></div>

                                <div class="col-md-2"><i class="fa fa-comment-o"></i><span class="hidden"> fa-comment-o</span></div>

                                <div class="col-md-2"><i class="fa fa-comments"></i><span class="hidden"> fa-comments</span></div>

                                <div class="col-md-2"><i class="fa fa-comments-o"></i><span class="hidden"> fa-comments-o</span></div>

                                <div class="col-md-2"><i class="fa fa-compass"></i><span class="hidden"> fa-compass</span></div>

                                <div class="col-md-2"><i class="fa fa-credit-card"></i><span class="hidden"> fa-credit-card</span></div>

                                <div class="col-md-2"><i class="fa fa-crop"></i><span class="hidden"> fa-crop</span></div>

                                <div class="col-md-2"><i class="fa fa-crosshairs"></i><span class="hidden"> fa-crosshairs</span></div>

                                <div class="col-md-2"><i class="fa fa-cube"></i><span class="hidden"> fa-cube</span></div>

                                <div class="col-md-2"><i class="fa fa-cubes"></i><span class="hidden"> fa-cubes</span></div>

                                <div class="col-md-2"><i class="fa fa-cutlery"></i><span class="hidden"> fa-cutlery</span></div>

                                <div class="col-md-2"><i class="fa fa-dashboard"></i><span class="hidden"> fa-dashboard </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-database"></i><span class="hidden"> fa-database</span></div>

                                <div class="col-md-2"><i class="fa fa-desktop"></i><span class="hidden"> fa-desktop</span></div>

                                <div class="col-md-2"><i class="fa fa-dot-circle-o"></i><span class="hidden"> fa-dot-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-download"></i><span class="hidden"> fa-download</span></div>

                                <div class="col-md-2"><i class="fa fa-edit"></i><span class="hidden"> fa-edit </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-ellipsis-h"></i><span class="hidden"> fa-ellipsis-h</span></div>

                                <div class="col-md-2"><i class="fa fa-ellipsis-v"></i><span class="hidden"> fa-ellipsis-v</span></div>

                                <div class="col-md-2"><i class="fa fa-envelope"></i><span class="hidden"> fa-envelope</span></div>

                                <div class="col-md-2"><i class="fa fa-envelope-o"></i><span class="hidden"> fa-envelope-o</span></div>

                                <div class="col-md-2"><i class="fa fa-envelope-square"></i><span class="hidden"> fa-envelope-square</span></div>

                                <div class="col-md-2"><i class="fa fa-eraser"></i><span class="hidden"> fa-eraser</span></div>

                                <div class="col-md-2"><i class="fa fa-exchange"></i><span class="hidden"> fa-exchange</span></div>

                                <div class="col-md-2"><i class="fa fa-exclamation"></i><span class="hidden"> fa-exclamation</span></div>

                                <div class="col-md-2"><i class="fa fa-exclamation-circle"></i><span class="hidden"> fa-exclamation-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-exclamation-triangle"></i><span class="hidden"> fa-exclamation-triangle</span></div>

                                <div class="col-md-2"><i class="fa fa-external-link"></i><span class="hidden"> fa-external-link</span></div>

                                <div class="col-md-2"><i class="fa fa-external-link-square"></i><span class="hidden"> fa-external-link-square</span></div>

                                <div class="col-md-2"><i class="fa fa-eye"></i><span class="hidden"> fa-eye</span></div>

                                <div class="col-md-2"><i class="fa fa-eye-slash"></i><span class="hidden"> fa-eye-slash</span></div>

                                <div class="col-md-2"><i class="fa fa-fax"></i><span class="hidden"> fa-fax</span></div>

                                <div class="col-md-2"><i class="fa fa-female"></i><span class="hidden"> fa-female</span></div>

                                <div class="col-md-2"><i class="fa fa-fighter-jet"></i><span class="hidden"> fa-fighter-jet</span></div>

                                <div class="col-md-2"><i class="fa fa-file-archive-o"></i><span class="hidden"> fa-file-archive-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-audio-o"></i><span class="hidden"> fa-file-audio-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-code-o"></i><span class="hidden"> fa-file-code-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-excel-o"></i><span class="hidden"> fa-file-excel-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-image-o"></i><span class="hidden"> fa-file-image-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-movie-o"></i><span class="hidden"> fa-file-movie-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-file-pdf-o"></i><span class="hidden"> fa-file-pdf-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-photo-o"></i><span class="hidden"> fa-file-photo-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-file-picture-o"></i><span class="hidden"> fa-file-picture-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-file-powerpoint-o"></i><span class="hidden"> fa-file-powerpoint-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-sound-o"></i><span class="hidden"> fa-file-sound-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-file-video-o"></i><span class="hidden"> fa-file-video-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-word-o"></i><span class="hidden"> fa-file-word-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-zip-o"></i><span class="hidden"> fa-file-zip-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-film"></i><span class="hidden"> fa-film</span></div>

                                <div class="col-md-2"><i class="fa fa-filter"></i><span class="hidden"> fa-filter</span></div>

                                <div class="col-md-2"><i class="fa fa-fire"></i><span class="hidden"> fa-fire</span></div>

                                <div class="col-md-2"><i class="fa fa-fire-extinguisher"></i><span class="hidden"> fa-fire-extinguisher</span></div>

                                <div class="col-md-2"><i class="fa fa-flag"></i><span class="hidden"> fa-flag</span></div>

                                <div class="col-md-2"><i class="fa fa-flag-checkered"></i><span class="hidden"> fa-flag-checkered</span></div>

                                <div class="col-md-2"><i class="fa fa-flag-o"></i><span class="hidden"> fa-flag-o</span></div>

                                <div class="col-md-2"><i class="fa fa-flash"></i><span class="hidden"> fa-flash </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-flask"></i><span class="hidden"> fa-flask</span></div>

                                <div class="col-md-2"><i class="fa fa-folder"></i><span class="hidden"> fa-folder</span></div>

                                <div class="col-md-2"><i class="fa fa-folder-o"></i><span class="hidden"> fa-folder-o</span></div>

                                <div class="col-md-2"><i class="fa fa-folder-open"></i><span class="hidden"> fa-folder-open</span></div>

                                <div class="col-md-2"><i class="fa fa-folder-open-o"></i><span class="hidden"> fa-folder-open-o</span></div>

                                <div class="col-md-2"><i class="fa fa-frown-o"></i><span class="hidden"> fa-frown-o</span></div>

                                <div class="col-md-2"><i class="fa fa-gamepad"></i><span class="hidden"> fa-gamepad</span></div>

                                <div class="col-md-2"><i class="fa fa-gavel"></i><span class="hidden"> fa-gavel</span></div>

                                <div class="col-md-2"><i class="fa fa-gear"></i><span class="hidden"> fa-gear </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-gears"></i><span class="hidden"> fa-gears </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-gift"></i><span class="hidden"> fa-gift</span></div>

                                <div class="col-md-2"><i class="fa fa-glass"></i><span class="hidden"> fa-glass</span></div>

                                <div class="col-md-2"><i class="fa fa-globe"></i><span class="hidden"> fa-globe</span></div>

                                <div class="col-md-2"><i class="fa fa-graduation-cap"></i><span class="hidden"> fa-graduation-cap</span></div>

                                <div class="col-md-2"><i class="fa fa-group"></i><span class="hidden"> fa-group </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-hdd-o"></i><span class="hidden"> fa-hdd-o</span></div>

                                <div class="col-md-2"><i class="fa fa-headphones"></i><span class="hidden"> fa-headphones</span></div>

                                <div class="col-md-2"><i class="fa fa-heart"></i><span class="hidden"> fa-heart</span></div>

                                <div class="col-md-2"><i class="fa fa-heart-o"></i><span class="hidden"> fa-heart-o</span></div>

                                <div class="col-md-2"><i class="fa fa-history"></i><span class="hidden"> fa-history</span></div>

                                <div class="col-md-2"><i class="fa fa-home"></i><span class="hidden"> fa-home</span></div>

                                <div class="col-md-2"><i class="fa fa-image"></i><span class="hidden"> fa-image </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-inbox"></i><span class="hidden"> fa-inbox</span></div>

                                <div class="col-md-2"><i class="fa fa-info"></i><span class="hidden"> fa-info</span></div>

                                <div class="col-md-2"><i class="fa fa-info-circle"></i><span class="hidden"> fa-info-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-institution"></i><span class="hidden"> fa-institution </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-key"></i><span class="hidden"> fa-key</span></div>

                                <div class="col-md-2"><i class="fa fa-keyboard-o"></i><span class="hidden"> fa-keyboard-o</span></div>

                                <div class="col-md-2"><i class="fa fa-language"></i><span class="hidden"> fa-language</span></div>

                                <div class="col-md-2"><i class="fa fa-laptop"></i><span class="hidden"> fa-laptop</span></div>

                                <div class="col-md-2"><i class="fa fa-leaf"></i><span class="hidden"> fa-leaf</span></div>

                                <div class="col-md-2"><i class="fa fa-legal"></i><span class="hidden"> fa-legal </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-lemon-o"></i><span class="hidden"> fa-lemon-o</span></div>

                                <div class="col-md-2"><i class="fa fa-level-down"></i><span class="hidden"> fa-level-down</span></div>

                                <div class="col-md-2"><i class="fa fa-level-up"></i><span class="hidden"> fa-level-up</span></div>

                                <div class="col-md-2"><i class="fa fa-life-bouy"></i><span class="hidden"> fa-life-bouy </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-life-ring"></i><span class="hidden"> fa-life-ring</span></div>

                                <div class="col-md-2"><i class="fa fa-life-saver"></i><span class="hidden"> fa-life-saver </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-lightbulb-o"></i><span class="hidden"> fa-lightbulb-o</span></div>

                                <div class="col-md-2"><i class="fa fa-location-arrow"></i><span class="hidden"> fa-location-arrow</span></div>

                                <div class="col-md-2"><i class="fa fa-lock"></i><span class="hidden"> fa-lock</span></div>

                                <div class="col-md-2"><i class="fa fa-magic"></i><span class="hidden"> fa-magic</span></div>

                                <div class="col-md-2"><i class="fa fa-magnet"></i><span class="hidden"> fa-magnet</span></div>

                                <div class="col-md-2"><i class="fa fa-mail-forward"></i><span class="hidden"> fa-mail-forward </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-mail-reply"></i><span class="hidden"> fa-mail-reply </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-mail-reply-all"></i><span class="hidden"> fa-mail-reply-all </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-male"></i><span class="hidden"> fa-male</span></div>

                                <div class="col-md-2"><i class="fa fa-map-marker"></i><span class="hidden"> fa-map-marker</span></div>

                                <div class="col-md-2"><i class="fa fa-meh-o"></i><span class="hidden"> fa-meh-o</span></div>

                                <div class="col-md-2"><i class="fa fa-microphone"></i><span class="hidden"> fa-microphone</span></div>

                                <div class="col-md-2"><i class="fa fa-microphone-slash"></i><span class="hidden"> fa-microphone-slash</span></div>

                                <div class="col-md-2"><i class="fa fa-minus"></i><span class="hidden"> fa-minus</span></div>

                                <div class="col-md-2"><i class="fa fa-minus-circle"></i><span class="hidden"> fa-minus-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-minus-square"></i><span class="hidden"> fa-minus-square</span></div>

                                <div class="col-md-2"><i class="fa fa-minus-square-o"></i><span class="hidden"> fa-minus-square-o</span></div>

                                <div class="col-md-2"><i class="fa fa-mobile"></i><span class="hidden"> fa-mobile</span></div>

                                <div class="col-md-2"><i class="fa fa-mobile-phone"></i><span class="hidden"> fa-mobile-phone </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-money"></i><span class="hidden"> fa-money</span></div>

                                <div class="col-md-2"><i class="fa fa-moon-o"></i><span class="hidden"> fa-moon-o</span></div>

                                <div class="col-md-2"><i class="fa fa-mortar-board"></i><span class="hidden"> fa-mortar-board </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-music"></i><span class="hidden"> fa-music</span></div>

                                <div class="col-md-2"><i class="fa fa-navicon"></i><span class="hidden"> fa-navicon </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-paper-plane"></i><span class="hidden"> fa-paper-plane</span></div>

                                <div class="col-md-2"><i class="fa fa-paper-plane-o"></i><span class="hidden"> fa-paper-plane-o</span></div>

                                <div class="col-md-2"><i class="fa fa-paw"></i><span class="hidden"> fa-paw</span></div>

                                <div class="col-md-2"><i class="fa fa-pencil"></i><span class="hidden"> fa-pencil</span></div>

                                <div class="col-md-2"><i class="fa fa-pencil-square"></i><span class="hidden"> fa-pencil-square</span></div>

                                <div class="col-md-2"><i class="fa fa-pencil-square-o"></i><span class="hidden"> fa-pencil-square-o</span></div>

                                <div class="col-md-2"><i class="fa fa-phone"></i><span class="hidden"> fa-phone</span></div>

                                <div class="col-md-2"><i class="fa fa-phone-square"></i><span class="hidden"> fa-phone-square</span></div>

                                <div class="col-md-2"><i class="fa fa-photo"></i><span class="hidden"> fa-photo </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-picture-o"></i><span class="hidden"> fa-picture-o</span></div>

                                <div class="col-md-2"><i class="fa fa-plane"></i><span class="hidden"> fa-plane</span></div>

                                <div class="col-md-2"><i class="fa fa-plus"></i><span class="hidden"> fa-plus</span></div>

                                <div class="col-md-2"><i class="fa fa-plus-circle"></i><span class="hidden"> fa-plus-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-plus-square"></i><span class="hidden"> fa-plus-square</span></div>

                                <div class="col-md-2"><i class="fa fa-plus-square-o"></i><span class="hidden"> fa-plus-square-o</span></div>

                                <div class="col-md-2"><i class="fa fa-power-off"></i><span class="hidden"> fa-power-off</span></div>

                                <div class="col-md-2"><i class="fa fa-print"></i><span class="hidden"> fa-print</span></div>

                                <div class="col-md-2"><i class="fa fa-puzzle-piece"></i><span class="hidden"> fa-puzzle-piece</span></div>

                                <div class="col-md-2"><i class="fa fa-qrcode"></i><span class="hidden"> fa-qrcode</span></div>

                                <div class="col-md-2"><i class="fa fa-question"></i><span class="hidden"> fa-question</span></div>

                                <div class="col-md-2"><i class="fa fa-question-circle"></i><span class="hidden"> fa-question-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-quote-left"></i><span class="hidden"> fa-quote-left</span></div>

                                <div class="col-md-2"><i class="fa fa-quote-right"></i><span class="hidden"> fa-quote-right</span></div>

                                <div class="col-md-2"><i class="fa fa-random"></i><span class="hidden"> fa-random</span></div>

                                <div class="col-md-2"><i class="fa fa-recycle"></i><span class="hidden"> fa-recycle</span></div>

                                <div class="col-md-2"><i class="fa fa-refresh"></i><span class="hidden"> fa-refresh</span></div>

                                <div class="col-md-2"><i class="fa fa-reorder"></i><span class="hidden"> fa-reorder </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-reply"></i><span class="hidden"> fa-reply</span></div>

                                <div class="col-md-2"><i class="fa fa-reply-all"></i><span class="hidden"> fa-reply-all</span></div>

                                <div class="col-md-2"><i class="fa fa-retweet"></i><span class="hidden"> fa-retweet</span></div>

                                <div class="col-md-2"><i class="fa fa-road"></i><span class="hidden"> fa-road</span></div>

                                <div class="col-md-2"><i class="fa fa-rocket"></i><span class="hidden"> fa-rocket</span></div>

                                <div class="col-md-2"><i class="fa fa-rss"></i><span class="hidden"> fa-rss</span></div>

                                <div class="col-md-2"><i class="fa fa-rss-square"></i><span class="hidden"> fa-rss-square</span></div>

                                <div class="col-md-2"><i class="fa fa-search"></i><span class="hidden"> fa-search</span></div>

                                <div class="col-md-2"><i class="fa fa-search-minus"></i><span class="hidden"> fa-search-minus</span></div>

                                <div class="col-md-2"><i class="fa fa-search-plus"></i><span class="hidden"> fa-search-plus</span></div>

                                <div class="col-md-2"><i class="fa fa-send"></i><span class="hidden"> fa-send </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-send-o"></i><span class="hidden"> fa-send-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-share"></i><span class="hidden"> fa-share</span></div>

                                <div class="col-md-2"><i class="fa fa-share-alt"></i><span class="hidden"> fa-share-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-share-alt-square"></i><span class="hidden"> fa-share-alt-square</span></div>

                                <div class="col-md-2"><i class="fa fa-share-square"></i><span class="hidden"> fa-share-square</span></div>

                                <div class="col-md-2"><i class="fa fa-share-square-o"></i><span class="hidden"> fa-share-square-o</span></div>

                                <div class="col-md-2"><i class="fa fa-shield"></i><span class="hidden"> fa-shield</span></div>

                                <div class="col-md-2"><i class="fa fa-shopping-cart"></i><span class="hidden"> fa-shopping-cart</span></div>

                                <div class="col-md-2"><i class="fa fa-sign-in"></i><span class="hidden"> fa-sign-in</span></div>

                                <div class="col-md-2"><i class="fa fa-sign-out"></i><span class="hidden"> fa-sign-out</span></div>

                                <div class="col-md-2"><i class="fa fa-signal"></i><span class="hidden"> fa-signal</span></div>

                                <div class="col-md-2"><i class="fa fa-sitemap"></i><span class="hidden"> fa-sitemap</span></div>

                                <div class="col-md-2"><i class="fa fa-sliders"></i><span class="hidden"> fa-sliders</span></div>

                                <div class="col-md-2"><i class="fa fa-smile-o"></i><span class="hidden"> fa-smile-o</span></div>

                                <div class="col-md-2"><i class="fa fa-sort"></i><span class="hidden"> fa-sort</span></div>

                                <div class="col-md-2"><i class="fa fa-sort-alpha-asc"></i><span class="hidden"> fa-sort-alpha-asc</span></div>

                                <div class="col-md-2"><i class="fa fa-sort-alpha-desc"></i><span class="hidden"> fa-sort-alpha-desc</span></div>

                                <div class="col-md-2"><i class="fa fa-sort-amount-asc"></i><span class="hidden"> fa-sort-amount-asc</span></div>

                                <div class="col-md-2"><i class="fa fa-sort-amount-desc"></i><span class="hidden"> fa-sort-amount-desc</span></div>

                                <div class="col-md-2"><i class="fa fa-sort-asc"></i><span class="hidden"> fa-sort-asc</span></div>

                                <div class="col-md-2"><i class="fa fa-sort-desc"></i><span class="hidden"> fa-sort-desc</span></div>

                                <div class="col-md-2"><i class="fa fa-sort-down"></i><span class="hidden"> fa-sort-down </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-sort-numeric-asc"></i><span class="hidden"> fa-sort-numeric-asc</span></div>

                                <div class="col-md-2"><i class="fa fa-sort-numeric-desc"></i><span class="hidden"> fa-sort-numeric-desc</span></div>

                                <div class="col-md-2"><i class="fa fa-sort-up"></i><span class="hidden"> fa-sort-up </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-space-shuttle"></i><span class="hidden"> fa-space-shuttle</span></div>

                                <div class="col-md-2"><i class="fa fa-spinner"></i><span class="hidden"> fa-spinner</span></div>

                                <div class="col-md-2"><i class="fa fa-spoon"></i><span class="hidden"> fa-spoon</span></div>

                                <div class="col-md-2"><i class="fa fa-square"></i><span class="hidden"> fa-square</span></div>

                                <div class="col-md-2"><i class="fa fa-square-o"></i><span class="hidden"> fa-square-o</span></div>

                                <div class="col-md-2"><i class="fa fa-star"></i><span class="hidden"> fa-star</span></div>

                                <div class="col-md-2"><i class="fa fa-star-half"></i><span class="hidden"> fa-star-half</span></div>

                                <div class="col-md-2"><i class="fa fa-star-half-empty"></i><span class="hidden"> fa-star-half-empty </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-star-half-full"></i><span class="hidden"> fa-star-half-full </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-star-half-o"></i><span class="hidden"> fa-star-half-o</span></div>

                                <div class="col-md-2"><i class="fa fa-star-o"></i><span class="hidden"> fa-star-o</span></div>

                                <div class="col-md-2"><i class="fa fa-suitcase"></i><span class="hidden"> fa-suitcase</span></div>

                                <div class="col-md-2"><i class="fa fa-sun-o"></i><span class="hidden"> fa-sun-o</span></div>

                                <div class="col-md-2"><i class="fa fa-support"></i><span class="hidden"> fa-support </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-tablet"></i><span class="hidden"> fa-tablet</span></div>

                                <div class="col-md-2"><i class="fa fa-tachometer"></i><span class="hidden"> fa-tachometer</span></div>

                                <div class="col-md-2"><i class="fa fa-tag"></i><span class="hidden"> fa-tag</span></div>

                                <div class="col-md-2"><i class="fa fa-tags"></i><span class="hidden"> fa-tags</span></div>

                                <div class="col-md-2"><i class="fa fa-tasks"></i><span class="hidden"> fa-tasks</span></div>

                                <div class="col-md-2"><i class="fa fa-taxi"></i><span class="hidden"> fa-taxi</span></div>

                                <div class="col-md-2"><i class="fa fa-terminal"></i><span class="hidden"> fa-terminal</span></div>

                                <div class="col-md-2"><i class="fa fa-thumb-tack"></i><span class="hidden"> fa-thumb-tack</span></div>

                                <div class="col-md-2"><i class="fa fa-thumbs-down"></i><span class="hidden"> fa-thumbs-down</span></div>

                                <div class="col-md-2"><i class="fa fa-thumbs-o-down"></i><span class="hidden"> fa-thumbs-o-down</span></div>

                                <div class="col-md-2"><i class="fa fa-thumbs-o-up"></i><span class="hidden"> fa-thumbs-o-up</span></div>

                                <div class="col-md-2"><i class="fa fa-thumbs-up"></i><span class="hidden"> fa-thumbs-up</span></div>

                                <div class="col-md-2"><i class="fa fa-ticket"></i><span class="hidden"> fa-ticket</span></div>

                                <div class="col-md-2"><i class="fa fa-times"></i><span class="hidden"> fa-times</span></div>

                                <div class="col-md-2"><i class="fa fa-times-circle"></i><span class="hidden"> fa-times-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-times-circle-o"></i><span class="hidden"> fa-times-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-tint"></i><span class="hidden"> fa-tint</span></div>

                                <div class="col-md-2"><i class="fa fa-toggle-down"></i><span class="hidden"> fa-toggle-down </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-toggle-left"></i><span class="hidden"> fa-toggle-left </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-toggle-right"></i><span class="hidden"> fa-toggle-right </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-toggle-up"></i><span class="hidden"> fa-toggle-up </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-trash-o"></i><span class="hidden"> fa-trash-o</span></div>

                                <div class="col-md-2"><i class="fa fa-tree"></i><span class="hidden"> fa-tree</span></div>

                                <div class="col-md-2"><i class="fa fa-trophy"></i><span class="hidden"> fa-trophy</span></div>

                                <div class="col-md-2"><i class="fa fa-truck"></i><span class="hidden"> fa-truck</span></div>

                                <div class="col-md-2"><i class="fa fa-umbrella"></i><span class="hidden"> fa-umbrella</span></div>

                                <div class="col-md-2"><i class="fa fa-university"></i><span class="hidden"> fa-university</span></div>

                                <div class="col-md-2"><i class="fa fa-unlock"></i><span class="hidden"> fa-unlock</span></div>

                                <div class="col-md-2"><i class="fa fa-unlock-alt"></i><span class="hidden"> fa-unlock-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-unsorted"></i><span class="hidden"> fa-unsorted </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-upload"></i><span class="hidden"> fa-upload</span></div>

                                <div class="col-md-2"><i class="fa fa-user"></i><span class="hidden"> fa-user</span></div>

                                <div class="col-md-2"><i class="fa fa-users"></i><span class="hidden"> fa-users</span></div>

                                <div class="col-md-2"><i class="fa fa-video-camera"></i><span class="hidden"> fa-video-camera</span></div>

                                <div class="col-md-2"><i class="fa fa-volume-down"></i><span class="hidden"> fa-volume-down</span></div>

                                <div class="col-md-2"><i class="fa fa-volume-off"></i><span class="hidden"> fa-volume-off</span></div>

                                <div class="col-md-2"><i class="fa fa-volume-up"></i><span class="hidden"> fa-volume-up</span></div>

                                <div class="col-md-2"><i class="fa fa-warning"></i><span class="hidden"> fa-warning </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-wheelchair"></i><span class="hidden"> fa-wheelchair</span></div>

                                <div class="col-md-2"><i class="fa fa-wrench"></i><span class="hidden"> fa-wrench</span></div>

                            </div>

                        </section>


                        <section id="file-type">


                            <div class="row icon-list-demo">

                                <div class="col-md-2"><i class="fa fa-file"></i><span class="hidden"> fa-file</span></div>

                                <div class="col-md-2"><i class="fa fa-file-archive-o"></i><span class="hidden"> fa-file-archive-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-audio-o"></i><span class="hidden"> fa-file-audio-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-code-o"></i><span class="hidden"> fa-file-code-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-excel-o"></i><span class="hidden"> fa-file-excel-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-image-o"></i><span class="hidden"> fa-file-image-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-movie-o"></i><span class="hidden"> fa-file-movie-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-file-o"></i><span class="hidden"> fa-file-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-pdf-o"></i><span class="hidden"> fa-file-pdf-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-photo-o"></i><span class="hidden"> fa-file-photo-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-file-picture-o"></i><span class="hidden"> fa-file-picture-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-file-powerpoint-o"></i><span class="hidden"> fa-file-powerpoint-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-sound-o"></i><span class="hidden"> fa-file-sound-o </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-file-text"></i><span class="hidden"> fa-file-text</span></div>

                                <div class="col-md-2"><i class="fa fa-file-text-o"></i><span class="hidden"> fa-file-text-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-video-o"></i><span class="hidden"> fa-file-video-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-word-o"></i><span class="hidden"> fa-file-word-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-zip-o"></i><span class="hidden"> fa-file-zip-o </span>
                                </div>

                            </div>

                        </section>

                        <section id="spinner">



                            <div class="row icon-list-demo">
                                <div class="col-md-2"><i class="fa fa-spin fa-circle-o-notch" style="width: auto;height: auto; line-height: 1px; margin-right: 10px;"></i><span class="hidden"> fa-circle-o-notch</span></div>

                                <div class="col-md-2"><i class="fa fa-spin fa-cog" style="width: auto;height: auto; line-height: 1px; margin-right: 10px;"></i><span class="hidden"> fa-cog</span></div>

                                <div class="col-md-2"><i class="fa fa-spin fa-gear" style="width: auto;height: auto; line-height: 1px; margin-right: 10px;"></i><span class="hidden"> fa-gear </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-spin fa-refresh" style="width: auto;height: auto; line-height: 1px; margin-right: 10px;"></i><span class="hidden"> fa-refresh</span></div>

                                <div class="col-md-2"><i class="fa fa-spin fa-spinner" style="width: auto;height: auto; line-height: 1px; margin-right: 10px;"></i><span class="hidden"> fa-spinner</span></div>

                            </div>
                        </section>

                        <section id="form-control">


                            <div class="row icon-list-demo">



                                <div class="col-md-2"><i class="fa fa-check-square"></i><span class="hidden"> fa-check-square</span></div>

                                <div class="col-md-2"><i class="fa fa-check-square-o"></i><span class="hidden"> fa-check-square-o</span></div>

                                <div class="col-md-2"><i class="fa fa-circle"></i><span class="hidden"> fa-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-circle-o"></i><span class="hidden"> fa-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-dot-circle-o"></i><span class="hidden"> fa-dot-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-minus-square"></i><span class="hidden"> fa-minus-square</span></div>

                                <div class="col-md-2"><i class="fa fa-minus-square-o"></i><span class="hidden"> fa-minus-square-o</span></div>

                                <div class="col-md-2"><i class="fa fa-plus-square"></i><span class="hidden"> fa-plus-square</span></div>

                                <div class="col-md-2"><i class="fa fa-plus-square-o"></i><span class="hidden"> fa-plus-square-o</span></div>

                                <div class="col-md-2"><i class="fa fa-square"></i><span class="hidden"> fa-square</span></div>

                                <div class="col-md-2"><i class="fa fa-square-o"></i><span class="hidden"> fa-square-o</span></div>

                            </div>
                        </section>

                        <section id="currency">


                            <div class="row icon-list-demo">



                                <div class="col-md-2"><i class="fa fa-bitcoin"></i><span class="hidden"> fa-bitcoin </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-btc"></i><span class="hidden"> fa-btc</span></div>

                                <div class="col-md-2"><i class="fa fa-cny"></i><span class="hidden"> fa-cny </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-dollar"></i><span class="hidden"> fa-dollar </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-eur"></i><span class="hidden"> fa-eur</span></div>

                                <div class="col-md-2"><i class="fa fa-euro"></i><span class="hidden"> fa-euro </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-gbp"></i><span class="hidden"> fa-gbp</span></div>

                                <div class="col-md-2"><i class="fa fa-inr"></i><span class="hidden"> fa-inr</span></div>

                                <div class="col-md-2"><i class="fa fa-jpy"></i><span class="hidden"> fa-jpy</span></div>

                                <div class="col-md-2"><i class="fa fa-krw"></i><span class="hidden"> fa-krw</span></div>

                                <div class="col-md-2"><i class="fa fa-money"></i><span class="hidden"> fa-money</span></div>

                                <div class="col-md-2"><i class="fa fa-rmb"></i><span class="hidden"> fa-rmb </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-rouble"></i><span class="hidden"> fa-rouble </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-rub"></i><span class="hidden"> fa-rub</span></div>

                                <div class="col-md-2"><i class="fa fa-ruble"></i><span class="hidden"> fa-ruble </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-rupee"></i><span class="hidden"> fa-rupee </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-try"></i><span class="hidden"> fa-try</span></div>

                                <div class="col-md-2"><i class="fa fa-turkish-lira"></i><span class="hidden"> fa-turkish-lira </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-usd"></i><span class="hidden"> fa-usd</span></div>

                                <div class="col-md-2"><i class="fa fa-won"></i><span class="hidden"> fa-won </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-yen"></i><span class="hidden"> fa-yen </span>
                                </div>

                            </div>

                        </section>

                        <section id="text-editor">


                            <div class="row icon-list-demo">



                                <div class="col-md-2"><i class="fa fa-align-center"></i><span class="hidden"> fa-align-center</span></div>

                                <div class="col-md-2"><i class="fa fa-align-justify"></i><span class="hidden"> fa-align-justify</span></div>

                                <div class="col-md-2"><i class="fa fa-align-left"></i><span class="hidden"> fa-align-left</span></div>

                                <div class="col-md-2"><i class="fa fa-align-right"></i><span class="hidden"> fa-align-right</span></div>

                                <div class="col-md-2"><i class="fa fa-bold"></i><span class="hidden"> fa-bold</span></div>

                                <div class="col-md-2"><i class="fa fa-chain"></i><span class="hidden"> fa-chain </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-chain-broken"></i><span class="hidden"> fa-chain-broken</span></div>

                                <div class="col-md-2"><i class="fa fa-clipboard"></i><span class="hidden"> fa-clipboard</span></div>

                                <div class="col-md-2"><i class="fa fa-columns"></i><span class="hidden"> fa-columns</span></div>

                                <div class="col-md-2"><i class="fa fa-copy"></i><span class="hidden"> fa-copy </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-cut"></i><span class="hidden"> fa-cut </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-dedent"></i><span class="hidden"> fa-dedent </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-eraser"></i><span class="hidden"> fa-eraser</span></div>

                                <div class="col-md-2"><i class="fa fa-file"></i><span class="hidden"> fa-file</span></div>

                                <div class="col-md-2"><i class="fa fa-file-o"></i><span class="hidden"> fa-file-o</span></div>

                                <div class="col-md-2"><i class="fa fa-file-text"></i><span class="hidden"> fa-file-text</span></div>

                                <div class="col-md-2"><i class="fa fa-file-text-o"></i><span class="hidden"> fa-file-text-o</span></div>

                                <div class="col-md-2"><i class="fa fa-files-o"></i><span class="hidden"> fa-files-o</span></div>

                                <div class="col-md-2"><i class="fa fa-floppy-o"></i><span class="hidden"> fa-floppy-o</span></div>

                                <div class="col-md-2"><i class="fa fa-font"></i><span class="hidden"> fa-font</span></div>

                                <div class="col-md-2"><i class="fa fa-header"></i><span class="hidden"> fa-header</span></div>

                                <div class="col-md-2"><i class="fa fa-indent"></i><span class="hidden"> fa-indent</span></div>

                                <div class="col-md-2"><i class="fa fa-italic"></i><span class="hidden"> fa-italic</span></div>

                                <div class="col-md-2"><i class="fa fa-link"></i><span class="hidden"> fa-link</span></div>

                                <div class="col-md-2"><i class="fa fa-list"></i><span class="hidden"> fa-list</span></div>

                                <div class="col-md-2"><i class="fa fa-list-alt"></i><span class="hidden"> fa-list-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-list-ol"></i><span class="hidden"> fa-list-ol</span></div>

                                <div class="col-md-2"><i class="fa fa-list-ul"></i><span class="hidden"> fa-list-ul</span></div>

                                <div class="col-md-2"><i class="fa fa-outdent"></i><span class="hidden"> fa-outdent</span></div>

                                <div class="col-md-2"><i class="fa fa-paperclip"></i><span class="hidden"> fa-paperclip</span></div>

                                <div class="col-md-2"><i class="fa fa-paragraph"></i><span class="hidden"> fa-paragraph</span></div>

                                <div class="col-md-2"><i class="fa fa-paste"></i><span class="hidden"> fa-paste </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-repeat"></i><span class="hidden"> fa-repeat</span></div>

                                <div class="col-md-2"><i class="fa fa-rotate-left"></i><span class="hidden"> fa-rotate-left </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-rotate-right"></i><span class="hidden"> fa-rotate-right </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-save"></i><span class="hidden"> fa-save </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-scissors"></i><span class="hidden"> fa-scissors</span></div>

                                <div class="col-md-2"><i class="fa fa-strikethrough"></i><span class="hidden"> fa-strikethrough</span></div>

                                <div class="col-md-2"><i class="fa fa-subscript"></i><span class="hidden"> fa-subscript</span></div>

                                <div class="col-md-2"><i class="fa fa-superscript"></i><span class="hidden"> fa-superscript</span></div>

                                <div class="col-md-2"><i class="fa fa-table"></i><span class="hidden"> fa-table</span></div>

                                <div class="col-md-2"><i class="fa fa-text-height"></i><span class="hidden"> fa-text-height</span></div>

                                <div class="col-md-2"><i class="fa fa-text-width"></i><span class="hidden"> fa-text-width</span></div>

                                <div class="col-md-2"><i class="fa fa-th"></i><span class="hidden"> fa-th</span></div>

                                <div class="col-md-2"><i class="fa fa-th-large"></i><span class="hidden"> fa-th-large</span></div>

                                <div class="col-md-2"><i class="fa fa-th-list"></i><span class="hidden"> fa-th-list</span></div>

                                <div class="col-md-2"><i class="fa fa-underline"></i><span class="hidden"> fa-underline</span></div>

                                <div class="col-md-2"><i class="fa fa-undo"></i><span class="hidden"> fa-undo</span></div>

                                <div class="col-md-2"><i class="fa fa-unlink"></i><span class="hidden"> fa-unlink </span>
                                </div>

                            </div>

                        </section>


                        <section id="directional">


                            <div class="row icon-list-demo">



                                <div class="col-md-2"><i class="fa fa-angle-double-down"></i><span class="hidden"> fa-angle-double-down</span></div>

                                <div class="col-md-2"><i class="fa fa-angle-double-left"></i><span class="hidden"> fa-angle-double-left</span></div>

                                <div class="col-md-2"><i class="fa fa-angle-double-right"></i><span class="hidden"> fa-angle-double-right</span></div>

                                <div class="col-md-2"><i class="fa fa-angle-double-up"></i><span class="hidden"> fa-angle-double-up</span></div>

                                <div class="col-md-2"><i class="fa fa-angle-down"></i><span class="hidden"> fa-angle-down</span></div>

                                <div class="col-md-2"><i class="fa fa-angle-left"></i><span class="hidden"> fa-angle-left</span></div>

                                <div class="col-md-2"><i class="fa fa-angle-right"></i><span class="hidden"> fa-angle-right</span></div>

                                <div class="col-md-2"><i class="fa fa-angle-up"></i><span class="hidden"> fa-angle-up</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-circle-down"></i><span class="hidden"> fa-arrow-circle-down</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-circle-left"></i><span class="hidden"> fa-arrow-circle-left</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-circle-o-down"></i><span class="hidden"> fa-arrow-circle-o-down</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-circle-o-left"></i><span class="hidden"> fa-arrow-circle-o-left</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-circle-o-right"></i><span class="hidden"> fa-arrow-circle-o-right</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-circle-o-up"></i><span class="hidden"> fa-arrow-circle-o-up</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-circle-right"></i><span class="hidden"> fa-arrow-circle-right</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-circle-up"></i><span class="hidden"> fa-arrow-circle-up</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-down"></i><span class="hidden"> fa-arrow-down</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-left"></i><span class="hidden"> fa-arrow-left</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-right"></i><span class="hidden"> fa-arrow-right</span></div>

                                <div class="col-md-2"><i class="fa fa-arrow-up"></i><span class="hidden"> fa-arrow-up</span></div>

                                <div class="col-md-2"><i class="fa fa-arrows"></i><span class="hidden"> fa-arrows</span></div>

                                <div class="col-md-2"><i class="fa fa-arrows-alt"></i><span class="hidden"> fa-arrows-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-arrows-h"></i><span class="hidden"> fa-arrows-h</span></div>

                                <div class="col-md-2"><i class="fa fa-arrows-v"></i><span class="hidden"> fa-arrows-v</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-down"></i><span class="hidden"> fa-caret-down</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-left"></i><span class="hidden"> fa-caret-left</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-right"></i><span class="hidden"> fa-caret-right</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-up"></i><span class="hidden"> fa-caret-up</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-square-o-left"></i><span class="hidden"> fa-caret-square-o-left</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-square-o-right"></i><span class="hidden"> fa-caret-square-o-right</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-square-o-up"></i><span class="hidden"> fa-caret-square-o-up</span></div>

                                <div class="col-md-2"><i class="fa fa-caret-square-o-down"></i><span class="hidden"> fa-caret-square-o-down</span></div>

                                <div class="col-md-2"><i class="fa fa-chevron-circle-down"></i><span class="hidden"> fa-chevron-circle-down</span></div>

                                <div class="col-md-2"><i class="fa fa-chevron-circle-left"></i><span class="hidden"> fa-chevron-circle-left</span></div>

                                <div class="col-md-2"><i class="fa fa-chevron-circle-right"></i><span class="hidden"> fa-chevron-circle-right</span></div>

                                <div class="col-md-2"><i class="fa fa-chevron-circle-up"></i><span class="hidden"> fa-chevron-circle-up</span></div>

                                <div class="col-md-2"><i class="fa fa-chevron-down"></i><span class="hidden"> fa-chevron-down</span></div>

                                <div class="col-md-2"><i class="fa fa-chevron-left"></i><span class="hidden"> fa-chevron-left</span></div>

                                <div class="col-md-2"><i class="fa fa-chevron-right"></i><span class="hidden"> fa-chevron-right</span></div>

                                <div class="col-md-2"><i class="fa fa-chevron-up"></i><span class="hidden"> fa-chevron-up</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-o-down"></i><span class="hidden"> fa-hand-o-down</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-o-left"></i><span class="hidden"> fa-hand-o-left</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-o-right"></i><span class="hidden"> fa-hand-o-right</span></div>

                                <div class="col-md-2"><i class="fa fa-hand-o-up"></i><span class="hidden"> fa-hand-o-up</span></div>

                                <div class="col-md-2"><i class="fa fa-long-arrow-down"></i><span class="hidden"> fa-long-arrow-down</span></div>

                                <div class="col-md-2"><i class="fa fa-long-arrow-left"></i><span class="hidden"> fa-long-arrow-left</span></div>

                                <div class="col-md-2"><i class="fa fa-long-arrow-right"></i><span class="hidden"> fa-long-arrow-right</span></div>

                                <div class="col-md-2"><i class="fa fa-long-arrow-up"></i><span class="hidden"> fa-long-arrow-up</span></div>

                                <div class="col-md-2"><i class="fa fa-toggle-down"></i><span class="hidden"> fa-toggle-down </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-toggle-left"></i><span class="hidden"> fa-toggle-left </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-toggle-right"></i><span class="hidden"> fa-toggle-right </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-toggle-up"></i><span class="hidden"> fa-toggle-up </span>
                                </div>

                            </div>

                        </section>

                        <section id="video-player">


                            <div class="row icon-list-demo">



                                <div class="col-md-2"><i class="fa fa-arrows-alt"></i><span class="hidden"> fa-arrows-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-backward"></i><span class="hidden"> fa-backward</span></div>

                                <div class="col-md-2"><i class="fa fa-compress"></i><span class="hidden"> fa-compress</span></div>

                                <div class="col-md-2"><i class="fa fa-eject"></i><span class="hidden"> fa-eject</span></div>

                                <div class="col-md-2"><i class="fa fa-expand"></i><span class="hidden"> fa-expand</span></div>

                                <div class="col-md-2"><i class="fa fa-fast-backward"></i><span class="hidden"> fa-fast-backward</span></div>

                                <div class="col-md-2"><i class="fa fa-fast-forward"></i><span class="hidden"> fa-fast-forward</span></div>

                                <div class="col-md-2"><i class="fa fa-forward"></i><span class="hidden"> fa-forward</span></div>

                                <div class="col-md-2"><i class="fa fa-pause"></i><span class="hidden"> fa-pause</span></div>

                                <div class="col-md-2"><i class="fa fa-play"></i><span class="hidden"> fa-play</span></div>

                                <div class="col-md-2"><i class="fa fa-play-circle"></i><span class="hidden"> fa-play-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-play-circle-o"></i><span class="hidden"> fa-play-circle-o</span></div>

                                <div class="col-md-2"><i class="fa fa-step-backward"></i><span class="hidden"> fa-step-backward</span></div>

                                <div class="col-md-2"><i class="fa fa-step-forward"></i><span class="hidden"> fa-step-forward</span></div>

                                <div class="col-md-2"><i class="fa fa-stop"></i><span class="hidden"> fa-stop</span></div>

                                <div class="col-md-2"><i class="fa fa-youtube-play"></i><span class="hidden"> fa-youtube-play</span></div>

                            </div>

                        </section>

                        <section id="brand">
                            <div class="row icon-list-demo">

                                <div class="col-md-2"><i class="fa fa-adn"></i><span class="hidden"> fa-adn</span></div>

                                <div class="col-md-2"><i class="fa fa-android"></i><span class="hidden"> fa-android</span></div>

                                <div class="col-md-2"><i class="fa fa-apple"></i><span class="hidden"> fa-apple</span></div>

                                <div class="col-md-2"><i class="fa fa-behance"></i><span class="hidden"> fa-behance</span></div>

                                <div class="col-md-2"><i class="fa fa-behance-square"></i><span class="hidden"> fa-behance-square</span></div>

                                <div class="col-md-2"><i class="fa fa-bitbucket"></i><span class="hidden"> fa-bitbucket</span></div>

                                <div class="col-md-2"><i class="fa fa-bitbucket-square"></i><span class="hidden"> fa-bitbucket-square</span></div>

                                <div class="col-md-2"><i class="fa fa-bitcoin"></i><span class="hidden"> fa-bitcoin </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-btc"></i><span class="hidden"> fa-btc</span></div>

                                <div class="col-md-2"><i class="fa fa-codepen"></i><span class="hidden"> fa-codepen</span></div>

                                <div class="col-md-2"><i class="fa fa-css3"></i><span class="hidden"> fa-css3</span></div>

                                <div class="col-md-2"><i class="fa fa-delicious"></i><span class="hidden"> fa-delicious</span></div>

                                <div class="col-md-2"><i class="fa fa-deviantart"></i><span class="hidden"> fa-deviantart</span></div>

                                <div class="col-md-2"><i class="fa fa-digg"></i><span class="hidden"> fa-digg</span></div>

                                <div class="col-md-2"><i class="fa fa-dribbble"></i><span class="hidden"> fa-dribbble</span></div>

                                <div class="col-md-2"><i class="fa fa-dropbox"></i><span class="hidden"> fa-dropbox</span></div>

                                <div class="col-md-2"><i class="fa fa-drupal"></i><span class="hidden"> fa-drupal</span></div>

                                <div class="col-md-2"><i class="fa fa-empire"></i><span class="hidden"> fa-empire</span></div>

                                <div class="col-md-2"><i class="fa fa-facebook"></i><span class="hidden"> fa-facebook</span></div>

                                <div class="col-md-2"><i class="fa fa-facebook-square"></i><span class="hidden"> fa-facebook-square</span></div>

                                <div class="col-md-2"><i class="fa fa-flickr"></i><span class="hidden"> fa-flickr</span></div>

                                <div class="col-md-2"><i class="fa fa-foursquare"></i><span class="hidden"> fa-foursquare</span></div>

                                <div class="col-md-2"><i class="fa fa-ge"></i><span class="hidden"> fa-ge </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-git"></i><span class="hidden"> fa-git</span></div>

                                <div class="col-md-2"><i class="fa fa-git-square"></i><span class="hidden"> fa-git-square</span></div>

                                <div class="col-md-2"><i class="fa fa-github"></i><span class="hidden"> fa-github</span></div>

                                <div class="col-md-2"><i class="fa fa-github-alt"></i><span class="hidden"> fa-github-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-github-square"></i><span class="hidden"> fa-github-square</span></div>

                                <div class="col-md-2"><i class="fa fa-gittip"></i><span class="hidden"> fa-gittip</span></div>

                                <div class="col-md-2"><i class="fa fa-google"></i><span class="hidden"> fa-google</span></div>

                                <div class="col-md-2"><i class="fa fa-google-plus"></i><span class="hidden"> fa-google-plus</span></div>

                                <div class="col-md-2"><i class="fa fa-google-plus-square"></i><span class="hidden"> fa-google-plus-square</span></div>

                                <div class="col-md-2"><i class="fa fa-hacker-news"></i><span class="hidden"> fa-hacker-news</span></div>

                                <div class="col-md-2"><i class="fa fa-html5"></i><span class="hidden"> fa-html5</span></div>

                                <div class="col-md-2"><i class="fa fa-instagram"></i><span class="hidden"> fa-instagram</span></div>

                                <div class="col-md-2"><i class="fa fa-joomla"></i><span class="hidden"> fa-joomla</span></div>

                                <div class="col-md-2"><i class="fa fa-jsfiddle"></i><span class="hidden"> fa-jsfiddle</span></div>

                                <div class="col-md-2"><i class="fa fa-linkedin"></i><span class="hidden"> fa-linkedin</span></div>

                                <div class="col-md-2"><i class="fa fa-linkedin-square"></i><span class="hidden"> fa-linkedin-square</span></div>

                                <div class="col-md-2"><i class="fa fa-linux"></i><span class="hidden"> fa-linux</span></div>

                                <div class="col-md-2"><i class="fa fa-maxcdn"></i><span class="hidden"> fa-maxcdn</span></div>

                                <div class="col-md-2"><i class="fa fa-openid"></i><span class="hidden"> fa-openid</span></div>

                                <div class="col-md-2"><i class="fa fa-pagelines"></i><span class="hidden"> fa-pagelines</span></div>

                                <div class="col-md-2"><i class="fa fa-pied-piper"></i><span class="hidden"> fa-pied-piper</span></div>

                                <div class="col-md-2"><i class="fa fa-pied-piper-alt"></i><span class="hidden"> fa-pied-piper-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-pinterest"></i><span class="hidden"> fa-pinterest</span></div>

                                <div class="col-md-2"><i class="fa fa-pinterest-square"></i><span class="hidden"> fa-pinterest-square</span></div>

                                <div class="col-md-2"><i class="fa fa-qq"></i><span class="hidden"> fa-qq</span></div>

                                <div class="col-md-2"><i class="fa fa-ra"></i><span class="hidden"> fa-ra </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-rebel"></i><span class="hidden"> fa-rebel</span></div>

                                <div class="col-md-2"><i class="fa fa-reddit"></i><span class="hidden"> fa-reddit</span></div>

                                <div class="col-md-2"><i class="fa fa-reddit-square"></i><span class="hidden"> fa-reddit-square</span></div>

                                <div class="col-md-2"><i class="fa fa-renren"></i><span class="hidden"> fa-renren</span></div>

                                <div class="col-md-2"><i class="fa fa-share-alt"></i><span class="hidden"> fa-share-alt</span></div>

                                <div class="col-md-2"><i class="fa fa-share-alt-square"></i><span class="hidden"> fa-share-alt-square</span></div>

                                <div class="col-md-2"><i class="fa fa-skype"></i><span class="hidden"> fa-skype</span></div>

                                <div class="col-md-2"><i class="fa fa-slack"></i><span class="hidden"> fa-slack</span></div>

                                <div class="col-md-2"><i class="fa fa-soundcloud"></i><span class="hidden"> fa-soundcloud</span></div>

                                <div class="col-md-2"><i class="fa fa-spotify"></i><span class="hidden"> fa-spotify</span></div>

                                <div class="col-md-2"><i class="fa fa-stack-exchange"></i><span class="hidden"> fa-stack-exchange</span></div>

                                <div class="col-md-2"><i class="fa fa-stack-overflow"></i><span class="hidden"> fa-stack-overflow</span></div>

                                <div class="col-md-2"><i class="fa fa-steam"></i><span class="hidden"> fa-steam</span></div>

                                <div class="col-md-2"><i class="fa fa-steam-square"></i><span class="hidden"> fa-steam-square</span></div>

                                <div class="col-md-2"><i class="fa fa-stumbleupon"></i><span class="hidden"> fa-stumbleupon</span></div>

                                <div class="col-md-2"><i class="fa fa-stumbleupon-circle"></i><span class="hidden"> fa-stumbleupon-circle</span></div>

                                <div class="col-md-2"><i class="fa fa-tencent-weibo"></i><span class="hidden"> fa-tencent-weibo</span></div>

                                <div class="col-md-2"><i class="fa fa-trello"></i><span class="hidden"> fa-trello</span></div>

                                <div class="col-md-2"><i class="fa fa-tumblr"></i><span class="hidden"> fa-tumblr</span></div>

                                <div class="col-md-2"><i class="fa fa-tumblr-square"></i><span class="hidden"> fa-tumblr-square</span></div>

                                <div class="col-md-2"><i class="fa fa-twitter"></i><span class="hidden"> fa-twitter</span></div>

                                <div class="col-md-2"><i class="fa fa-twitter-square"></i><span class="hidden"> fa-twitter-square</span></div>

                                <div class="col-md-2"><i class="fa fa-vimeo-square"></i><span class="hidden"> fa-vimeo-square</span></div>

                                <div class="col-md-2"><i class="fa fa-vine"></i><span class="hidden"> fa-vine</span></div>

                                <div class="col-md-2"><i class="fa fa-vk"></i><span class="hidden"> fa-vk</span></div>

                                <div class="col-md-2"><i class="fa fa-wechat"></i><span class="hidden"> fa-wechat </span>
                                </div>

                                <div class="col-md-2"><i class="fa fa-weibo"></i><span class="hidden"> fa-weibo</span></div>

                                <div class="col-md-2"><i class="fa fa-weixin"></i><span class="hidden"> fa-weixin</span></div>

                                <div class="col-md-2"><i class="fa fa-windows"></i><span class="hidden"> fa-windows</span></div>

                                <div class="col-md-2"><i class="fa fa-wordpress"></i><span class="hidden"> fa-wordpress</span></div>

                                <div class="col-md-2"><i class="fa fa-xing"></i><span class="hidden"> fa-xing</span></div>

                                <div class="col-md-2"><i class="fa fa-xing-square"></i><span class="hidden"> fa-xing-square</span></div>

                                <div class="col-md-2"><i class="fa fa-yahoo"></i><span class="hidden"> fa-yahoo</span></div>

                                <div class="col-md-2"><i class="fa fa-youtube"></i><span class="hidden"> fa-youtube</span></div>

                                <div class="col-md-2"><i class="fa fa-youtube-play"></i><span class="hidden"> fa-youtube-play</span></div>

                                <div class="col-md-2"><i class="fa fa-youtube-square"></i><span class="hidden"> fa-youtube-square</span></div>

                            </div>
                        </section>

                        <section id="medical">


                            <div class="row icon-list-demo">
                                <div class="col-md-2"><i class="fa fa-ambulance"></i><span class="hidden"> fa-ambulance</span></div>

                                <div class="col-md-2"><i class="fa fa-h-square"></i><span class="hidden"> fa-h-square</span></div>

                                <div class="col-md-2"><i class="fa fa-hospital-o"></i><span class="hidden"> fa-hospital-o</span></div>

                                <div class="col-md-2"><i class="fa fa-medkit"></i><span class="hidden"> fa-medkit</span></div>

                                <div class="col-md-2"><i class="fa fa-plus-square"></i><span class="hidden"> fa-plus-square</span></div>

                                <div class="col-md-2"><i class="fa fa-stethoscope"></i><span class="hidden"> fa-stethoscope</span></div>

                                <div class="col-md-2"><i class="fa fa-user-md"></i><span class="hidden"> fa-user-md</span></div>

                                <div class="col-md-2"><i class="fa fa-wheelchair"></i><span class="hidden"> fa-wheelchair</span></div>

                                <div class="col-sm-6 col-md-4 col-lg-3 text-danger" id="no-matching-result">
                                    Sorry, no match found for given name
                                </div>
                            </div>

                        </section>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin_assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')  }}"></script>
    <script src="{{ asset('assets/js/icon_search.js')  }}"></script>
    <script>
        $(document).ready(function(){
            // show image
            $('#is_image').click(function (e) {
                if (this.checked){
                    $('#img-div').removeClass('hidden');
                    $('#icon-div').addClass('hidden');

                    $('#icon_val').attr('name', '');
                    $('.filestyle').attr('name', 'image');

                }
            });
            // show icon
            $('#is_icon').click(function (e) {
                if (this.checked){
                    $('#img-div').addClass('hidden');
                    // remove icone
                    $('#icon-div').removeClass('hidden');
                    $('#icon_val').attr('name', 'icon');
                    $('.filestyle').attr('name', '');
                }
            });

            // add icone
            $('#iconModal section .col-md-2').click(function () {
                var icon = $(this).find('i').attr('class');
                $('#myicon').removeClass('hidden').html('<i class="'+ icon +'"><i>');
                $('#icon_val').val(icon);
                $('#iconModal').modal('hide');

            });
            // category
            //clicking the parent checkbox should check or uncheck all child checkboxes
            $(".parentCheckBox").click(
                    function() {
                        $(this).parents('fieldset:eq(0)').find('.childCheckBox').attr('checked', this.checked);
                        //$(this).parents('fieldset:eq(0)').find('ul').toggle();
                    }
            );
            //clicking the last unchecked or checked checkbox should check or uncheck the parent checkbox
            //saving new user
            $("#add_group").submit(function(){
                $('#loading').show();
                var data = new FormData(this);
                $.ajax({
                    url: "<?php echo route('groups.store'); ?>",
                    data: data,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(result){
                        $('#loading').hide();
                        var data = JSON.parse(result);
                        if( data.msg == 'success' ){
                            var title = $('#title').val();
                            var id = data.id;
                            //$('#category option:first-child').after( '<option value="'+ id +'" >'+title+'</option>' );

                            if(category == false) {
                                $("#add_group")[0].reset();
                                // hide button and empty value
                                $('#myicon').addClass('hidden').html('');
                                $('#icon_val').val('');
                            }

                            swal("Success!", "Group added successfully.", "success");
                        }else if(data.msg == 'dup'){
                            swal("Error!", data.alert, "error");
                        }else if(data.msg == 2){
                            swal("Error!", data.error, "error");
                        }else{
                            swal("Error!", 'Something went wrong!', "error");
                        }
                    }
                });
                return false;
            });
        });
    </script>
@endsection

