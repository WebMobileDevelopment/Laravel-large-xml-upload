<template>
<div id="app">
    <div class="heading">
        <h1>Book Upload</h1>
    </div>
    <upload-files></upload-files>

    <h1>All Books</h1>

    <vueBook></vueBook>
</div>
</template>

<script>
import vueBook from "./components/vueBook.vue";
import UploadFiles from "./components/UploadFiles.vue";
// Vue.component('pagination', require('laravel-vue-pagination'));
export default {
    components: {
        vueBook,
        UploadFiles
    },
    data() {
        return {
            books: {},
        };
    },
    methods: {
    },
    watch: {},
    created() {},
    mounted() {},
};

//  <table class="table-bordered">
//         <thead>
//             <tr>
//                 <th>ISBN</th>
//                 <th>Title</th>
//             </tr>
//         </thead>
//         <tr v-for="book in books.data" :key="book.ISBN">
//             <td>{{ book.ISBN }}</td>
//             <td>{{ book.Title }}</td>
//         </tr>
//     </table>

//     <pagination :data="books" @pagination-change-page="getResults"></pagination>
//     <pagination :data="books">
//         <span slot="prev-nav">&lt; Previous</span>
//         <span slot="next-nav">Next &gt;</span>
//     </pagination>
</script>

<style>
#app {
    margin-left: 1em;
}

.heading h1 {
    margin-bottom: 0;
}
</style>
