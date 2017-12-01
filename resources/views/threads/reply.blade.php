<reply inline-template :attributes="{{ $reply }}" v-cloak>
    <div class="panel panel-default" id="reply-{{ $reply->id }}">
        <div class="panel-heading">
            <div class="level">
                <h5  class="flex">
                    <a href="{{ $reply->owner->profilePath() }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForhumans() }}...
                </h5>

                <div>
                    <form action="/replies/{{ $reply->id }}/favorites" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-default" type="submit" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                        </button>
                    </form>
                </div>
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

                <form method="POST" action="/replies/{{ $reply->id }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</reply>