<template>
    <div class="panel panel-default" :id="'reply-' + id" :class="isBest ? 'panel-success' : 'panel-default'">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/' + reply.owner.name"
                       v-text="reply.owner.name">
                    </a> said <span v-text="ago"></span>
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
                <form @submit.prevent="update">
                    <div class="form-group">
                        <wysiwig v-model="body"></wysiwig>
                    </div>

                    <button class="btn btn-xs btn-primary" type="submit">Update</button>
                    <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>

        <!--@can('update', $reply)-->
        <div class="panel-footer level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-xs mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-xs mr-1 btn-danger" @click="destroy">Delete</button>
            </div>
            <button class="btn btn-xs ml-a btn-default"
                    @click="markBestReply"
                    v-if="authorize('owns', reply.thread)"
                    v-show="! isBest">Best Reply?</button>
        </div>
        <!--@endcan-->
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';
    import Wysiwig from "./Wysiwig";

    export default {
        props: ['reply'],

        components: {Wysiwig, Favorite},

        computed: {
            ago() {
                return moment(this.reply.create_at).fromNow();
            }
        },

        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            };
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.id, {body: this.body})
                    .then(({data}) => {
                        this.editing = false;
                        flash('Your reply has been updated!');
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });


            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);
                flash('Your reply has been deleted!');
            },

            markBestReply() {
                axios.post(`/replies/${this.id}/best`);
                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>