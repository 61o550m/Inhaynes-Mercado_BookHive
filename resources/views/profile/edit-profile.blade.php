@extends('layouts.app')

@section('content')

<div class="edit-banner">
    <h1>Edit Profile</h1>

    <label for="avatarInput" class="avatar-edit-box">
        <div class="avatar-circle"
            style="background-image: url('{{ $user->avatar ? asset("storage/$user->avatar") : asset("img/default-avatar.png") }}');">
        </div>

        <img src="{{ asset('img/camera.png') }}" class="camera-icon">
    </label>
</div>

<form action="{{ route('myprofile.update') }}" method="POST" enctype="multipart/form-data" class="edit-form">
    @csrf

    <input type="file" id="avatarInput" name="avatar" style="display: none;">

    <label>Username</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}"
        placeholder="Enter your username">

    <label>Contact Number</label>
    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
        placeholder="Enter your contact number">

    <label>Bio</label>
    <textarea name="bio" placeholder="Enter your bio">{{ old('bio', $user->bio) }}</textarea>

    <div class="edit-btns">
        <button type="submit" class="save-btn">Save</button>

        <a href="{{ route('user.profile', $user->id) }}" class="cancel-btn7">Cancel</a>
    </div>
</form>

@endsection
