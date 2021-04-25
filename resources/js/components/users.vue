<template>
    <div class="container">
        <div class="active-pink-3 active-pink-4 mb-3">
            <input class="form-control" type="text" placeholder="Search" aria-label="Search" v-model="searchText" v-on:keypress.enter="search"/>
        </div>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">Creadted By</th>
                <th scope="col">Title</th>
                <th scope="col">Body</th>
                <th scope="col">Created Date</th>
                <th scope="col">Completed</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(todo,index) in todos.data" :key="todo.id">
                <th scope="row">{{todo.created_by}}</th>
                <td>{{ todo.title }}</td>
                <td>{{ todo.body }}</td>
                <td>{{todo.created_at}}</td>
                <td>{{todo.completed}}</td>
            </tr>
            </tbody>
        </table>
        <div v-if="todos.length === 0" class="text-center">
            No Item For Doing
        </div>
        <pagination :data="todos" @pagination-change-page="getResults"></pagination>

    </div>
</template>

<script>
export default {
    props:['userId'],
    data(){
        return{
            todos:{},
            searchText:''
        }
    },
    mounted() {
        this.getResults();
    },
    methods:{
        getResults(page = 1) {
            axios.get('api/todo/?page=' + page)
                .then(response => {
                    this.todos=response.data;
                });
        },
        search(){
            if (this.searchText==''){
                this.getResults();
            }
            else {

                axios.get('api/search/'+this.searchText)
                    .then(response=>{
                        this.todos=response.data
                    })
            }
        }
    }
}
</script>
