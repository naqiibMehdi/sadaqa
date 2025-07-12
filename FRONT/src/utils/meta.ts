import imageOpenGraph from "@/assets/default-image-open-graph.png"

export interface MetaInfo {
  title: string;
  description: string;
  image?: string;
  url?: string;
  type?: string;
}

export const setMeta = (meta: MetaInfo): void => {

  // Mettre à jour ou créer les balises meta Open Graph
  updateMetaTag('og:title', meta.title);
  updateMetaTag('og:description', meta.description);
  updateMetaTag('og:url', meta.url || window.location.href);
  updateMetaTag('og:type', meta.type || 'website');

  if (meta.image) {
    updateMetaTag('og:image', meta.image);
  }

  // Meta tags Twitter
  updateMetaTag('twitter:card', 'summary_large_image');
  updateMetaTag('twitter:title', meta.title);
  updateMetaTag('twitter:description', meta.description);
  updateMetaTag('twitter:url', meta.url || window.location.href);

  if (meta.image) {
    updateMetaTag('twitter:image', meta.image);
  }
};

const updateMetaTag = (name: string, content: string): void => {
  let meta = document.querySelector(`meta[property="${name}"]`);

  if (!meta) {
    meta = document.createElement('meta');
    meta.setAttribute('property', name);
    document.head.appendChild(meta);
  }

  meta.setAttribute('content', content);
};

// Définir les meta tags par défaut pour l'application
export const setDefaultMeta = (): void => {
  setMeta({
    title: 'Plateforme de Cagnotte - Créez et partagez vos cagnottes',
    description: 'Notre plateforme vous permet de créer et partager facilement des cagnottes pour tous vos projets collectifs.',
    image: "https://saddaqa.fr" + imageOpenGraph,
    type: 'website'
  });
};