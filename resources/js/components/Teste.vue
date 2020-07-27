<script>
    export default {
        props: ['posts'],

        data () {
            return {
                list: [],
            }
        },

        mounted() {
            this.list = JSON.parse(this.posts)
        }
    }
</script>

<template>
    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 60px">#</th>
                                <th>Title</th>
                                <th style="width: 100px">Author</th>
                                <th style="width: 130px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in list">
                                <td>{{ post.id }}</td>
                                <td>{{ post.title }}</td>
                                <td>{{ post.author }}</td>
                                <td>
                                    <a v-bind:href="'/posts/edit/' + post.slug" class="btn btn-sm btn-primary">edit</a>
                                    <a v-bind:href="'/posts/destroy/' + post.slug" class="btn btn-sm btn-danger">destroy</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
</template>
<style scoped=""></style>
