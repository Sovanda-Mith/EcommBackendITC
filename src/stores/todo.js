import { defineStore } from "pinia";
import axios from "axios";

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
        console.log(this.todos);
      } catch (error) {
        console.error("Failed to fetch todos:", error);
      }
    },

    async toggleStatus(id) {
      const foundIndex = this.todos.findIndex((t) => t.id == id);
      if (foundIndex >= 0) {
        if (this.todos[foundIndex].completedAt != null) {
          try {
            const response = await axios.patch(
              "http://localhost:3100/tasks/" + id + "/pending",
              {
                completedAt: null,
              },
            );
            if (response.status == 200) {
              this.todos[foundIndex].completedAt = null;
            }
          } catch (error) {
            console.error("Failed to update todo:", error);
          }
        } else {
          try {
            const response = await axios.patch(
              "http://localhost:3100/tasks/" + id + "/done",
              {
                completedAt: new Date().toISOString(),
              },
            );
            if (response.status == 200) {
              this.todos[foundIndex].completedAt = new Date().toISOString();
            }
          } catch (error) {
            console.error("Failed to update todo:", error);
          }
        }
      }
    },

    async addTodo(todo) {
      try {
        const response = await axios.post(
          "http://localhost:3100/tasks/",
          {
            name: todo,
            description: "description",
            userId: 2,
          },
          {
            headers: {
              "Content-Type": "application/json",
            },
          },
        );
        if (response.status == 201) {
          this.todos.push(response.data);
        }
      } catch (error) {
        console.error("Failed to add todo:", error);
      }
    },

    async clearAll() {
      try {
        const response = await axios.delete(
          "http://localhost:3100/tasks/clear-all",
        );
        if (response.status == 200) {
          this.todos = [];
        }
      } catch (error) {
        console.error("Failed to clear all todos:", error);
      }
    },
  },
});
