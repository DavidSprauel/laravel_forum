<template>
    <div>
        <div class="level">
            <img :src="avatar" width="50" height="50" class="mr-1">
            <h1 v-text="user.name"></h1>
        </div>

        <form v-if="canUpdate" method="post" enctype="multipart/form-data">
            <image-upload name="avatar" class="mr-1" @loaded="onLoad"></image-upload>
        </form>

    </div>
</template>

<script>
    import ImageUpload from './ImageUpload';

    export default {
        props:['user'], // Thing that are passed to the component

        components: { ImageUpload },

        data() { // Things defined in the template
            return {
                avatar: this.user.avatar_path
            }
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            }
        },

        methods: {
            onLoad(avatar) {
                this.persist(avatar.file);
                this.avatar = avatar.src;
            },

            persist(avatar) {
                let data = new FormData;
                data.append('avatar', avatar);

                axios.post(`/api/users/${this.user.name}/avatar`, data)
                    .then(() => flash('Avatar Uploaded!'));
            }
        }
    }
</script>