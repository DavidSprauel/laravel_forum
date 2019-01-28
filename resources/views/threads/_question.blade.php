{{-- EDITING THE QUESTION --}}
<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">
            <input type="text" name="title" v-model="form.title" class="form-control">
        </div>

    </div>

    <div class="panel-body text-justify">
        <div class="form-group">
            <textarea class="form-control" rows="10" v-model="form.body"></textarea>
        </div>
    </div>

    <div class="panel-footer">
        <div class="level">
            <button class="btn btn-xs level-item" @click="editing = true" v-show="! editing">Edit</button>
            <button class="btn btn-xs btn-primary level-item" @click="update">Update</button>
            <button class="btn btn-xs btn-warning level-item" @click="resetForm">Cancel</button>
            @can('update', $thread)
                <form method="POST" action="{{ $thread->path() }}" class="ml-a">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger btn-xs">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

{{-- VIEWING THE QUESTION --}}
<div class="panel panel-default" v-else>
    <div class="panel-heading">
        <div class="level">
            <img src="{{ $thread->creator->avatar_path }}"
                 width="25" height="25"
                 class="mr-1"
                 alt="{{ $thread->creator->name }}">
            <span class="flex">
                <a href="{{ $thread->creator->profilePath() }}">{{ $thread->creator->name }}</a> posted:
                <span v-text="title"></span>
            </span>
        </div>

    </div>

    <div class="panel-body text-justify" v-text="body"></div>

    <div class="panel-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-xs" @click="editing = true">Edit</button>
    </div>
</div>