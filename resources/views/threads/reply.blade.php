<reply inline-template :data="{{ $reply }}" v-cloak>
    <div class="panel panel-default" id="reply-{{ $reply->id }}">
        <div class="panel-heading">
            <div class="level">
                <h5  class="flex">
                    <a href="{{ $reply->owner->profilePath() }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForhumans() }}...
                </h5>

                @if(auth()->check())
                    <div>
                        <favorite :reply="{{ $reply }}"></favorite>
                    </div>
                @endif
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
            <div class="panel-footer level">
                <button class="btn btn-xs mr-1" @click="editing = true">
                    Edit
                </button>
                <button class="btn btn-xs mr-1 btn-danger" @click="destroy">
                    Delete
                </button>
            </div>
        @endcan
    </div>
</reply>