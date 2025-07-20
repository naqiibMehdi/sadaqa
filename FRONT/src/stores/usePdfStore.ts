import {acceptHMRUpdate, defineStore} from "pinia";
import {fetchData} from "@/utils/axios.ts";


interface propState {
  loadingStates: Map<number, boolean>
}

export const usePdfStore = defineStore("pdf", {
  state: (): propState => ({
    loadingStates: new Map<number, boolean>(),
  }),
  actions: {
    // Dans votre store ou service API
    async downloadCampaignPdf(campaignIdRecovery: string | number) {
      this.loadingStates.set(campaignIdRecovery as number, true)
      try {
        const response = await fetchData(`pdf/${campaignIdRecovery}`, {responseType: 'blob'});

        // Créer un blob et une URL pour le PDF
        const blob = new Blob([response], {type: 'application/pdf'});
        const url = window.URL.createObjectURL(blob);

        // Ouvrir le PDF dans un nouvel onglet
        window.open(url, '_blank');

        // Nettoyer l'URL après utilisation
        setTimeout(() => {
          window.URL.revokeObjectURL(url);
        }, 5000);

      } catch (error) {
        console.error('Erreur lors du téléchargement du PDF:', error);
        throw error;
      } finally {
        this.loadingStates.set(campaignIdRecovery as number, false)
      }
    }
  },
  getters: {
    isLoading: (state) => (id: number) => state.loadingStates.get(id) || false,

    hasAnyLoading: (state) => {
      for (const loading of state.loadingStates.values()) {
        if (loading) return true;
      }
      return false;
    }

  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(usePdfStore, import.meta.hot))
}