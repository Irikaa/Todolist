<template>
    <div class="container mx-auto mt-8 space-y-3 flex flex-col  sm:flex-col md:flex-col lg:flex-row">
      <!-- Table for TO DO LIST -->
      <div class="w-full p-4 order-2  ">
        <h1 class="text-center text-4xl font-bold">
          TO DO LIST
        </h1>
        <input v-model="search" class="w-full h-10 mb-2 border-2 border-gray-300 px-2 py-1 rounded-md focus:outline-none focus:ring focus:border-blue-500" placeholder="Search Here">
        <div class="w-full h-[500px] overflow-y-auto border-collapse rounded-xl shadow-xl">
        <table class="w-full ">
          <thead class="bg-gray-100">
            <tr>
              <th scope="col" class="sticky top-0 bg-gray-700 px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">No</th>
              <th scope="col" class="sticky top-0 bg-gray-700 px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Task Name</th>
              <th scope="col" class="sticky top-0 bg-gray-700 px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Status</th>
              <th scope="col" class="sticky top-0 bg-gray-700 px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Deadline</th>
              <th scope="col" class="sticky top-0 bg-gray-700 px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, i) in filteredTasks" :key="i" class="text-center">
              <td class="border border-gray-300 px-4 py-2"
                  :class="{  'bg-green-200': item.status === 'Completed', 'text-gray-500 line-through': item.status === 'Completed'}"
                  >{{ i + 1 }}</td>
              <td class="border border-gray-300 px-4 py-2"
                  :class="{  'bg-green-200': item.status === 'Completed', 'text-gray-500 line-through': item.status === 'Completed'}"
                  >{{ item.task_name }}</td>
              <td class="border border-gray-300 px-4 py-2"
                  :class="{ 'text-blue-500': item.status === 'In Progress' ,
                            'text-red-500': item.status === 'Not Yet Started',
                            'bg-green-200': item.status === 'Completed',
                            'text-gray-500 line-through': item.status === 'Completed'
                  }"
                  >{{ item.status }}</td>
              <td class="border border-gray-300 px-4 py-2"
                  :class="{ 'bg-green-200': item.status === 'Completed',
                            'text-gray-500 line-through': item.status === 'Completed'
                  }"
                  >{{ item.deadline }}</td>
              <td class="border border-gray-300 px-4 py-2" :class="{  'bg-green-200': item.status === 'Completed' }">
                <button @click="editTask(item, 'EDIT')" class="mr-2 p-1 rounded-md" title="Edit">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(0,158,6,1)"><path d="M16.7574 2.99677L14.7574 4.99677H5V18.9968H19V9.23941L21 7.23941V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99677C3 3.44448 3.44772 2.99677 4 2.99677H16.7574ZM20.4853 2.09727L21.8995 3.51149L12.7071 12.7039L11.2954 12.7063L11.2929 11.2897L20.4853 2.09727Z"></path></svg>
                </button>
                <button @click="deleteTask(item)" class="p-1 rounded-md" title="Delete">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(255,0,0,1)"><path d="M20 7V20C20 21.1046 19.1046 22 18 22H6C4.89543 22 4 21.1046 4 20V7H2V5H22V7H20ZM6 7V20H18V7H6ZM11 9H13V11H11V9ZM11 12H13V14H11V12ZM11 15H13V17H11V15ZM7 2H17V4H7V2Z"></path></svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
      
      <!-- Table for Adding Tasks -->
      <div class="w-full mx-auto  lg:w-1/4 xl:w-1/3  mx-2 order-1 ">
        <div class="flex flex-col justify-center">
          <h2 class="font-bold text-4xl mb-2 text-center uppercase ">{{ editingTask ? 'Edit Task' : 'Add Task' }}</h2>
          <form @submit.prevent="submitTask" class="mx-5 rounded-2xl border-2 p-4 shadow-2xl">
            <!-- TASK NAME -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700" for="taskName">Task Name:</label>
              <input class="w-full h-10 border border-gray-300 px-2 py-1 rounded-md focus:outline-none focus:ring focus:border-blue-500" v-model="taskForm.task_name" type="text" id="taskName" required>
            </div>
            <!-- TASK STATUS -->
            <div class="mb-4">
              <label for="taskStatus" class="block text-sm font-medium text-gray-700">Task Status:</label>
              <select v-model="taskForm.status" id="taskStatus" required class="w-full h-10 border border-gray-300 px-2 rounded-md focus:outline-none focus:ring focus:border-blue-500">
                <option value="Not Yet Started">Not Yet Started</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
              </select>
            </div>
            <!-- DEADLINE -->
            <div class="mb-4">
              <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline:</label>
              <input 
                id="dateTimePicker" 
                required
                type="datetime-local" 
                class="w-full h-10 border border-gray-300 px-2 rounded-md focus:outline-none focus:ring focus:border-blue-500"
                v-model="taskForm.deadline"
              />
              </div>
            <!-- BUTTONS -->
            <div class="flex flex-col lg:flex-row xl:flex-row justify-between space-y-2">
                <button class="p-2 bg-blue-500 text-white font-bold rounded-md uppercase" type="submit">{{ editingTask ? 'Update' : 'Save' }}</button>
                <button class="p-2 bg-red-500 text-white font-bold rounded-md uppercase" type="cancel">{{cancelBtn ? 'Cancel' : 'Clear'}}</button>
            </div>
          </form>
        </div>

        <!-- TALLY OF STATUS -->
        <div class="p-4 space-y-3">
            <div class="border-4 border-green-300 py-4  rounded-2xl shadow-2xl px-4 flex justify-center">
              <span class="font-bold  text-xl italic">{{'TOTAL COMPLETED :  '}}</span>
              <span class="font-bold text-xl italic ml-2">{{totalCountPerStatus.completed}}</span>
            </div>

            <div class="border-4 py-4 border-blue-300 rounded-2xl shadow-2xl px-4 flex justify-center">
              <span class="font-bold text-xl italic">{{'TOTAL IN PROGRESS :  '}}</span>
              <span class="font-bold text-xl italic ml-2">{{totalCountPerStatus.inProgress}}</span>
            </div>

            <div class="border-4 py-4 border-red-400 rounded-2xl shadow-2xl px-4 flex justify-center">
              <span class="font-bold text-xl italic">{{'TOTAL NOT YET STARTED :  '}}</span>
              <span class="font-bold text-xl italic ml-2">{{totalCountPerStatus.notYetStarted}}</span>
            </div>
        </div>
      </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed  } from 'vue';
import axiosHttp from '../axiosHttp.js';
  // DECLARATIONS
  let tasks = ref([]);
  let taskForm = ref({ task_name: '', status: '' });
  const editingTask = ref(false);
  const cancelBtn = ref(false);
  const search = ref('');
  // end of declaration
  // NOTE : SEARCH FUNCTION
  const filteredTasks = computed(() => {
    const newSearch = search.value.toLowerCase();
    return tasks.value.filter(task => {
      return Object.values(task).some(value => {
        return typeof value === 'string' && value.toLowerCase().includes(newSearch);
      });
    });
  });
  // NOTE : COUNT TOTAL PER STATUS
  const totalCountPerStatus = computed(() => {
    const countPerStatus = {
      completed: 0,
      inProgress: 0,
      notYetStarted: 0,
    };

    filteredTasks.value.forEach(task => {
      const status = task.status;
      if (status === 'Completed') {
        countPerStatus['completed'] += 1;
      } else if (status === 'In Progress') {
        countPerStatus['inProgress'] += 1;
      } else if (status === 'Not Yet Started') {
        countPerStatus['notYetStarted'] += 1;
      }
    });

    return countPerStatus;
  });
  // NOTE : GET ALL RECORDS OF TASKS
  async function getAllData(){
    axiosHttp.get('/get_data').then(({data}) => {
      if(data) tasks.value = data;
    })
  }
  // NOTE : ADD / EDIT
  async function submitTask(){
      taskForm.value.deadline = format(taskForm.value.deadline);
      // EDIT TASK
      if (editingTask.value) {
        const index = tasks.value.findIndex(task => task.id === taskForm.value.id);
        if (index !== -1) {
          tasks.value[index] = { ...taskForm.value };
          await axiosHttp.post('todo/update',{
            task : tasks.value[index],
          }).then(async () => { })
        }
      } else {
        // ADD NEW TASK
        // NOTE : CHECK FIRST IF TASK IS ALREADY EXISTING
        const isExisting = tasks.value.some(task => task.task_name === taskForm.value.task_name);
        // SAVE
        if(!isExisting){
          await axiosHttp.post('todo/insert',{
            task : taskForm.value,
          }).then(async () => { })
        }else{
          alert('Task is already existing');
        }

      }
        taskForm.value = { task_name: '', status: '' };
        editingTask.value = false;
        await getAllData();
  }
  // NOTE : ASSIGN TASK TO EDIT
  async function editTask(task){
      taskForm.value = { ...task };
      editingTask.value = true;
      cancelBtn.value = true;
  }
  // NOTE : DELETE TASK
  async function deleteTask(tasksToDelete){
      if (tasksToDelete) {
        await axiosHttp.post('todo/delete',{
          task : tasksToDelete,
        }).then(({data}) => {
          console.log(data)
          getAllData();
        })
      }
  }
  // NOTE : FORMAT DATE TIME
  function format(date){
    const dateObject = new Date(date);
    const year = dateObject.getFullYear();
    const month = (dateObject.getMonth() + 1).toString().padStart(2, '0');
    const day = dateObject.getDate().toString().padStart(2, '0');
    const hours = dateObject.getHours().toString().padStart(2, '0');
    const minutes = dateObject.getMinutes().toString().padStart(2, '0');

    return`${year}-${month}-${day} ${hours}:${minutes}`;

  }
  // NOTE : MOUNTED
  onMounted(() => {
    getAllData();
  });
</script>

<style lang="scss" scoped>

</style>