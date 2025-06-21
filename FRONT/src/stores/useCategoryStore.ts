import {acceptHMRUpdate, defineStore} from "pinia";
import {fetchData} from "@/utils/axios.ts";
import {AxiosError} from "axios";

interface typeState {
  categories: { id: number, name: string, translate_name: string }[],
  error: string
}

export const useCategoryStore = defineStore("category", {
  state: (): typeState => ({
    categories: [],
    error: ""
  }),
  actions: {
    async getCategories() {
      this.error = ""
      try {
        const response = await fetchData("/categories");
        this.categories = response.data
      } catch (err) {
        if (err instanceof AxiosError) {
          this.error = "Erreur de chargement des catégories"
        }
      }
    },

  },
  getters: {
    categoriesNames(): { name: string, label: string, to: { name: string, params: { category: string } } }[] {
      return this.categories.map(category => ({
            name: category.name,
            label: category.translate_name,
            to: {name: "campaigns", params: {category: category.name}},
          })
      )
    }
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useCategoryStore, import.meta.hot))
}