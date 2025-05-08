import { defineStore } from "pinia";

export const useTodoStore = defineStore("todo", {
  state: () => ({
    todos: [],
  }),
  getters: {
    countTodos: (state) => state.todos.length,
  },
  actions: {
    async fetchTodos() {
      try {
        const response = await axios.get("http://localhost:3100/tasks");
        this.todos = response.data; // assuming the API returns an array of todos
      } catch (error) {
        console.error("Failed to fetch todos:", error);
      }
    },

    toggleStatus(id) {
      const foundIndex = this.todos.findIndex((t) => t.id == id);
      if (foundIndex >= 0) {
        if (this.todos[foundIndex].completedAt != null) {
          this.todos[foundIndex].completedAt = null;
        } else {
          this.todos[foundIndex].completedAt = new Date().toISOString();
        }
      }
    },
    addTodo(todo) {
      this.todos.push({
        id: this.todos.length + 1,
        name: todo,
        description: "description",
        createdAt: new Date().toISOString(),
        completedAt: null,
      });
      this.todos = JSON.parse(JSON.stringify(this.todos));
    },
    clearAll() {
      this.todos = [];
    },
  },
});
