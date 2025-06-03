export function titleAndMetaTag(title: string, description: string) {
  // Mettre à jour le titre
  document.title = title

  // Mettre à jour la meta description
  let metaDescription = document.querySelector('meta[name="description"]')
  if (metaDescription) {
    metaDescription.setAttribute('content', description)
  } else {
    metaDescription = document.createElement('meta')
    metaDescription.setAttribute('name', 'description')
    metaDescription.setAttribute('content', description)
    document.head.appendChild(metaDescription)
  }
}