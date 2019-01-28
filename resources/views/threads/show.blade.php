@extends('layouts.app')

@section('head-end')
    <link href="{{ asset('css/jquery.atwho.css') }}" rel="stylesheet">
@endsection

@section('content')
    <thread-view inline-template :thread="{{ $thread }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8" v-cloak>
                    @include('threads._question')

                    <replies @removed="repliesCount--" @added="repliesCount++"></replies>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a> and currently has
                                <span v-text="repliesCount"></span>
                                {{ str_plural('comment', $thread->replies_count) }}
                            </p>
                            <p>
                                <subscribe-button v-if="signedIn" :thread="{{ $thread }}"></subscribe-button>

                                <button class="btn btn-default"
                                        v-if="authorize('isAdmin')"
                                        v-text="locked ? 'Unlock' : 'Lock'"
                                        @click="toggleLock"
                                >Lock</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
