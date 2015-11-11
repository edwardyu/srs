<!-- resources/views/emails/password.blade.php -->
@extends('layouts.master')
@section('title', 'Reset Password')
@section('content')
Click here to reset your password: {{ url('password/reset/'.$token) }}
@endsection
