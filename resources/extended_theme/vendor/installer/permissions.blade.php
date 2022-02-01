
@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.permissions.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-key fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.permissions.title') }}
@endsection

@section('container')
    <p class="text-center btn btn-xs btn-primary pull-right" style="cursor: help; margin:5px" data-toggle="modal" data-target="#permissionModal"> Need Help?</p>
    <div class="clearfix"></div>
    <ul class="list">
        @foreach($permissions['permissions'] as $permission)
        <li class="list__item list__item--permissions {{ $permission['isSet'] ? 'success' : 'error' }}">
            {{ $permission['folder'] }}
            <span>
                <i class="fa fa-fw fa-{{ $permission['isSet'] ? 'check-circle-o' : 'exclamation-circle' }}"></i>
                {{ $permission['permission'] }}
            </span>
        </li>
        @endforeach
    </ul>

    @if ( ! isset($permissions['errors']))
        <div class="buttons">
            <a href="{{ route('LaravelInstaller::database') }}" class="button">
                {!! trans('installer_messages.environment.classic.install') !!}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </a>
        </div>
        @else
        <p class="text-center text-danger"> <i class="fa fa-warning"></i> please refresh page if you have fixed above error! </p>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="permissionModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">User Guide by Ranksol</h4>
                </div>
                <div class="modal-body">
                    <h3 id="db_cr"><strong>B) Assign Permissions</strong></h3>
                    <p> Login to your cpanel / server </p>
                    <p> You need to assign 755 permission to following folders if any missing </p>
                    <p> Go to root directory of application </p>
                        <ul>
                        <li>storage/framework/</li>
                        <li>storage/logs/</li>
                        <li>bootstrap/cache/</li>
                    </ul>
                    <p> See instructions in below mentioned screen shots step by step. </p>

                    <img src="{{ asset('installer/img/permission-1.png') }}" alt="" width="100%"><br>
                    <hr>
                    <img src="{{ asset('installer/img/assign_permission.png') }}" alt="" width="100%"><br>
                    <hr>
                    <p class="text-success">Permission assigned successfully</p>
                    <p>Repeat same procedure to assign permissions to storage folder</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
