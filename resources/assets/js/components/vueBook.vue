<template>
<div>
    <div class="row">
        <div class="col-md-offset-8 col-md-4">
            <input type="text" class="form-control" v-model="filter" placeholder="search" @keyup="search()" id="search_input" />
        </div>
    </div>
    <div class="row">
        <div class="text-center col-md-12">
            <Pagination :resultData="resultData" @clicked="init" :mid-size="9"></Pagination>
        </div>
    </div>

    <table class="table loader-form" v-cloak>
        <thead>
            <tr class="tr">
                <th>No</th>
                <th>Title</th>
                <th>ISBN</th>
            </tr>
        </thead>
        <tbody v-if="resultData.data != ''">
            <tr class="tr" v-for="(value, index) in resultData.data" :key="value.id">
                <td>{{ index + 1 }}</td>
                <td class="searchable" :content="value.Title">{{ value.Title }}</td>
                <td class="searchable" :content="value.ISBN">{{ value.ISBN }}</td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td colspan="3">No data have found !</td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="text-center col-md-12">
            <Pagination :resultData="resultData" @clicked="init" :mid-size="9"></Pagination>
        </div>
    </div>
</div>
</template>

<script>
// import {
//     EventBus
// } from '../vue-assets';
import Pagination from "./Pagination";
export default {
    components: {
        Pagination,
    },
    data: function () {
        return {
            resultData: {},
            filter: "",
            test: 0,
        };
    },
    methods: {
        init(pageNo, filter) {
            var self = this;
            if (pageNo) {
                pageNo = pageNo;
            } else {
                pageNo = this.resultData.current_page;
            }
            if (filter) {
                filter = filter;
            } else {
                filter = "";
            }
            axios
                .get(base_url + "books?page=" + pageNo + "&search=" + filter)
                .then((res) => {
                    self.resultData = res.data;
                    self.test = 1;
                });
        },

        search() {
            var vm = this;
            vm.init(1, vm.filter);
        },
        range(start, count) {
            return Array.apply(0, Array(count)).map(function (element, index) {
                return index + start;
            });
        },
    },
    mounted() {
        this.init(1, "");
    },
    updated() {
        let self = this;
        $(".searchable").each(function () {
            if (self.filter == "") {
                $(this).html($(this).attr("content"));
            } else {
                var search_regexp = new RegExp(self.filter, "g");
                $(this).html(
                    $(this)
                    .attr("content")
                    .replace(
                        search_regexp,
                        "<span class = 'highlight'>" + self.filter + "</span>"
                    )
                );
            }
        });
    },
};
$(function () {});
</script>
