@extends('EscortAdmin::layout')

@pushAssets('styles.post')
    <link href="{{ asset('assets/theme/admin/default/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet" />
@endPushAssets

@section('main.content.title')
    <i class="mdi mdi-video"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    {{-- public --}}
    @include('EscortAdmin::videos.components.public_videos')
    {{-- end public --}}

    {{-- private --}}
    @include('EscortAdmin::videos.components.private_videos')
    {{-- end private --}}
@endsection

@pushAssets('scripts.post')
    <script src="{{ asset('assets/theme/admin/default/plugins/dropify/dist/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/theme/admin/default/js/growl.min.js') }}"></script>
    <script type="text/javascript">
        // init constants here
        const PUBLIC_UPLOAD_URL = '{{ route("escort_admin.videos.upload_public_video") }}';
        const PRIVATE_UPLOAD_URL = '{{ route("escort_admin.videos.upload_private_video") }}';
        const PUBLIC_DELETE_URL = '{{ route("escort_admin.videos.delete_public_video") }}';
        const PRIVATE_DELETE_URL = '{{ route("escort_admin.videos.delete_private_video") }}';
        const CREATE_FOLDER_URL = '{{ route("escort_admin.videos.private_create_folder") }}';
        const SWITCH_FOLDER_URL = '{{ route("escort_admin.videos.private_switch_folder") }}';
        const RENAME_FOLDER_URL = '{{ route("escort_admin.videos.private_rename_folder") }}';
        const DELETE_FOLDER_URL = '{{ route("escort_admin.videos.private_delete_folder") }}';
    </script>
    <script src="{{ asset('assets/theme/admin/default/js/escort_admin/videos.js') }}"></script>
@endPushAssets
