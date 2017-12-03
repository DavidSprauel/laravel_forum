<template>
    <button :class="classes" @click="subscribe" v-text="subscribed">
    </button>
</template>

<script>
    export default {
        props: ['thread'],

        data() {
            return {
                active: this.thread.isSubscribedTo
            }
        },

        computed: {
            classes() {
                return [
                    'btn',
                    this.active ? 'btn-primary' : 'btn-default'
                ]
            },

            subscribed() {
                return this.active ? 'Subscribed' : 'Subscribe';
            }
        },

        methods: {
            subscribe() {
                let requestType = this.active ? 'delete' : 'post';

                axios[requestType](location.pathname + '/subscriptions').then(() => {
                    this.active =  ! this.active;
                });
            },

        }
    }
</script>