// FormCreateCampaignView.functional.spec.ts
import {describe, it, expect, vi, beforeEach} from 'vitest'
import {mount, flushPromises, VueWrapper} from '@vue/test-utils'
import FormCreateCampaignView from '../src/pages/forms/FormCreateCampaignView.vue'
import {createPinia, setActivePinia} from 'pinia'

// Mock des dépendances
const mockRouter = {
  push: vi.fn()
}

vi.mock('vue-router', () => ({
  useRouter: () => mockRouter
}))

// Mock des stores
const mockCampaignStore = {
  createCampaign: vi.fn(),
  errorsFormCampaign: null,
  loading: false
}

const mockCategoryStore = {
  getCategories: vi.fn(),
  categories: [
    {id: 1, name: 'Santé'},
    {id: 2, name: 'Éducation'},
    {id: 3, name: 'Environnement'}
  ]
}

vi.mock('@/stores/useCampaignStore', () => ({
  useCampaignStore: vi.fn(() => mockCampaignStore)
}))

vi.mock('@/stores/useCategoryStore', () => ({
  useCategoryStore: vi.fn(() => mockCategoryStore)
}))

// Configuration des stubs
const stubs = {
  'Header': true,
  'Main': {
    template: '<div><slot /></div>'
  },
  'Footer': true,
  'InputField': {
    props: ['modelValue', 'placeholder', 'id', 'title', 'type', 'invalid'],
    template: '<div><label v-if="title" :for="id">{{ title }}</label><input :id="id" :type="type || \'text\'" :placeholder="placeholder" :value="modelValue" @input="$emit(\'update:modelValue\', $event.target.value)" /></div>',
    emits: ['update:modelValue']
  },
  'CustomButton': {
    props: ['label', 'type', 'loading', 'disabled'],
    template: '<button :type="type || \'button\'" :disabled="loading === true || disabled === true">{{ label }}</button>',
    emits: []
  },
  'QuillEditor': {
    props: ['modelValue'],
    template: '<div class="editor"><textarea :value="modelValue" @input="$emit(\'update:modelValue\', $event.target.value)"></textarea></div>',
    emits: ['update:modelValue']
  },
  'FileUploader': {
    props: ['modelValue'],
    template: '<div class="file-uploader"><input type="file" @change="$emit(\'update:modelValue\', \'mocked-file.jpg\')" /></div>',
    emits: ['update:modelValue']
  },
  'Select': {
    props: ['options', 'optionLabel', 'optionValue', 'modelValue', 'placeholder', 'labelId', 'invalid'],
    template: '<select :value="modelValue" @change="$emit(\'update:modelValue\', $event.target.value)"><option v-for="option in options" :key="option[optionValue]" :value="option[optionValue]">{{ option[optionLabel] }}</option></select>',
    emits: ['update:modelValue']
  },
  'Message': {
    props: ['severity', 'variant', 'size'],
    template: '<div class="error-message" :data-severity="severity"><slot /></div>'
  }
};

describe('FormCreateCampaignView - Test Fonctionnel', () => {
  let wrapper: VueWrapper

  beforeEach(() => {
    vi.clearAllMocks()

    // Réinitialiser les propriétés du store
    mockCampaignStore.errorsFormCampaign = null
    mockCampaignStore.loading = false
    mockCampaignStore.createCampaign.mockReset()

    // Initialiser Pinia
    setActivePinia(createPinia())

    // Monter le composant avec les stubs nécessaires
    wrapper = mount(FormCreateCampaignView, {
      global: {stubs}
    })
  })

  it('réinitialise le formulaire et redirige après la création réussie d\'une campagne', async () => {
    // Configurer le mock pour simuler une création réussie
    mockCampaignStore.createCampaign.mockResolvedValue({
      data: {id: 123, slug: 'ma-nouvelle-campagne'}
    })

    // Remplir le formulaire
    await wrapper.find('input[placeholder="Titre de la cagnotte"]').setValue('Ma campagne de test')
    await wrapper.find('select').setValue('2')
    await wrapper.find('input[placeholder="Ex: 10"]').setValue('100')
    await wrapper.find('textarea').setValue('Description détaillée de ma campagne')
    await wrapper.find('input[type="file"]').trigger('change')

    // Soumettre le formulaire
    await wrapper.find('form').trigger('submit.prevent')

    // Attendre que les promesses soient résolues
    await flushPromises()

    // Vérifier que la redirection a eu lieu
    expect(mockRouter.push).toHaveBeenCalledWith({
      name: 'campaign',
      params: {slug: 'ma-nouvelle-campagne', id: 123}
    })
  })

  it('affiche les erreurs de validation si la création échoue', async () => {
    // Configurer le mock pour simuler une erreur de validation
    const validationErrors = {
      title: ['Le titre est obligatoire'],
      description: ['La description est obligatoire'],
      image: ['L\'image est obligatoire'],
      target_amount: ['Le montant cible doit être un nombre positif'],
      category_id: ['Veuillez sélectionner une catégorie']
    }

    mockCampaignStore.createCampaign.mockImplementation(async () => {
      mockCampaignStore.errorsFormCampaign = validationErrors
      return Promise.resolve(null)
    })

    // Soumettre le formulaire sans remplir les champs
    await wrapper.find('form').trigger('submit.prevent')

    // Attendre que les promesses soient résolues
    await flushPromises()

    // Remonter le composant pour s'assurer que les erreurs sont bien prises en compte
    wrapper = mount(FormCreateCampaignView, {
      global: {stubs}
    });

    // Vérifier que les messages d'erreur sont rendus dans le DOM
    // En cherchant directement les contenus des erreurs
    expect(wrapper.html()).toContain('Le titre est obligatoire');
    expect(wrapper.html()).toContain('Veuillez sélectionner une catégorie');
    expect(wrapper.html()).toContain('Le montant cible doit être un nombre positif');

  })

  it('désactive le bouton de soumission pendant le chargement', async () => {
    // Configurer le mock pour simuler le chargement
    mockCampaignStore.loading = true;

    // Remonter le composant avec le store mis à jour
    wrapper = mount(FormCreateCampaignView, {
      global: {stubs}
    });

    // Vérifier que le bouton est désactivé
    const submitButton = wrapper.find('button[type="submit"]');
    expect(submitButton.attributes("disabled")).toBeDefined();
  })

  it('convertit correctement le montant cible en centimes lors de la soumission', async () => {
    // Configurer le mock pour une création réussie
    mockCampaignStore.createCampaign.mockResolvedValue({
      data: {id: 123, slug: 'ma-nouvelle-campagne'}
    })

    // Remplir le formulaire avec un montant
    await wrapper.find('input[placeholder="Titre de la cagnotte"]').setValue('Ma campagne de test')
    await wrapper.find('select').setValue('2')
    await wrapper.find('input[placeholder="Ex: 10"]').setValue('150.75')
    await wrapper.find('textarea').setValue('Description détaillée de ma campagne')
    await wrapper.find('input[type="file"]').trigger('change')

    // Soumettre le formulaire
    await wrapper.find('form').trigger('submit.prevent')

    // Attendre que les promesses soient résolues
    await flushPromises()

    // Vérifier que le montant a été converti en centimes (150.75 * 100 = 15075)
    expect(mockCampaignStore.createCampaign).toHaveBeenCalledWith(
        expect.objectContaining({
          target_amount: 15075
        })
    )
  })
})