@extends('layouts.app')

@section('head-end')
    <link href="{{ asset('css/jquery.atwho.css') }}" rel="stylesheet">
@endsection

@section('content')
    <thread-view inline-template :thread="{{ $thread }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <img src="{{ $thread->creator->avatar_path }}"
                                     width="25" height="25"
                                     class="mr-1"
                                     alt="{{ $thread->creator->name }}">
                                <span class="flex">
                                <a href="{{ $thread->creator->profilePath() }}">{{ $thread->creator->name }}</a> posted:
                                    {{ $thread->title }}
                                </span>

                                @can('update', $thread)
                                    <form method="POST" action="{{ $thread->path() }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>

                        </div>

                        <div class="panel-body text-justify">
                            {!! nl2br($thread->body) !!}
                        </div>
                    </div>

                    <replies @removed="repliesCount--"
                             @added="repliesCount++"></replies>

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
                                <subscribe-button
                                        v-if="signedIn"
                                        :thread="{{ $thread }}">
                                </subscribe-button>

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
