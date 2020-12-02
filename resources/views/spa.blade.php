@extends('layouts.app')

@section('aside')
    <menu1 super_admin="{{$super_admin}}" app_name="{{ config('app.name') }}" app_logo="{{ config('app.logo') }}" app_logo_compacted="{{ config('app.logo_compacted') }}"
           email_help="{{ config('app.help_name') }}" app_role="{{ config('app.role') }}"></menu1>
@endsection

@section('content')
    <router-view super_admin="{{$super_admin}}" app_name="{{ config('app.name') }}" stripe_key="{{ config('services.stripe.key') }}" app_role="{{ config('app.role') }}"></router-view>
@endsection
