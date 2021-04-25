<template>
    <div class="container">
        <a href="#create" class="btn btn-success float-right mb-2" data-toggle="modal">Create</a>
        <div class="active-pink-3 active-pink-4 mb-3">
            <input class="form-control" type="text" placeholder="Search" aria-label="Search" v-model="searchText" v-on:keypress.enter="search"/>
        </div>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Body</th>
                <th scope="col">Created Date</th>
                <th scope="col">Completed</th>
                <th>Acitons</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(todo,index) in todos.data" :key="todo.id">
                <th scope="row">{{index+1}}</th>
                <td>{{ todo.title }}</td>
                <td>{{ todo.body }}</td>
                <td>{{todo.created_at}}</td>
                <td>{{todo.completed}}</td>
                <td>
                    <a href="#delete" @click="deleteItem(todo.id)" data-toggle="modal">Delete</a>
                    <a href="#exampleModal"  @click="editItem(todo.id)" data-toggle="modal">Edit</a>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-if="todos.length === 0" class="text-center">
            No Item For Doing
        </div>
        <pagination :data="todos" @pagination-change-page="getResults"></pagination>
        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure for deleting this item?
                        <form action="">
                            <input type="hidden" v-model="deleteId">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="remove()">Delete User</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <input type="text" class="form-control" id="body" v-model="editBody" aria-describedby="body" placeholder="Enter body">
                            </div>
                            <div class="form-group">
                                <label for="editTitle">Title</label>
                                <input type="text" class="form-control" id="editTitle"  v-model="editTitle" aria-describedby="editTitle" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label >is done?</label>
                                <input type="checkbox" class="form-control" id="editCompleted"  v-model="editCompleted" aria-describedby="editCompleted"  checked>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="update()" data-dismiss="modal">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <input type="text" class="form-control"  v-model="createBody"  placeholder="Enter body">
                            </div>
                            <div class="form-group">
                                <label for="editTitle">Title</label>
                                <input type="text" class="form-control"   v-model="createTitle"  placeholder="Enter title">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="create()" data-dismiss="modal">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['userId'],
        data(){
            return{
                todos:{},
                deleteId:'',
                editBody:'',
                editTitle:'',
                editCompleted:'',
                editId:'',
                createBody:'',
                createTitle:'',
                searchText:''
            }
        },
        mounted() {
            this.getResults();
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/todos/'+this.userId+'?page=' + page)
                    .then(response => {
                      this.todos=response.data;
                    });
            },
            deleteItem(id){
                this.deleteId=id;
            },
            remove(){
                axios.delete('api/todo/'+this.deleteId,{
                }).then(response=>{
                    console.log(response.data)
                    this.getResults();
                })
            },
            editItem(id){
                axios.get('api/todo/'+id)
                    .then(response =>{
                        this.editId=response.data.id;
                        this.editBody=response.data.body;
                        this.editTitle=response.data.title;
                        this.editCompleted=response.data.completed;
                    });
            },
            update(){
                axios.put('api/todo/'+this.editId,{
                    body:this.editBody,
                    title:this.editTitle,
                    completed:this.editCompleted
                })
                    .then(response=>{
                        console.log(response.data);
                        this.getResults();
                    })
            },
            create(){
                axios.post('api/todo',{
                    id:this.userId,
                    body:this.createBody,
                    title:this.createTitle
                }).then(response=>{
                    console.log(response.data);
                    this.getResults();
                })
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
