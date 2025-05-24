// FormCreateCampaignView.spec.ts
import {describe, it, expect, vi, beforeEach, Mock} from 'vitest'
import {mount, flushPromises, VueWrapper} from '@vue/test-utils'
import FormCreateCampaignView from '../src/pages/forms/FormCreateCampaignView.vue'
import {createPinia, setActivePinia} from 'pinia'
import {useCampaignStore} from '../src/stores/useCampaignStore'
import {useCategoryStore} from '../src/stores/useCategoryStore'

// Mock des dépendances
const mockRouter = {
  push: vi.fn()
}

vi.mock('vue-router', () => ({
  useRouter: () => mockRouter
}))

// Mock des stores
vi.mock('../src/stores/useCampaignStore', () => ({
  useCampaignStore: vi.fn()
}))

vi.mock('../src/stores/useCategoryStore', () => ({
  useCategoryStore: vi.fn()
}))

describe('FormCreateCampaignView - Test Unitaire', () => {
  let wrapper: VueWrapper
  let mockCreateCampaign: Mock
  let mockGetCategories: Mock

  beforeEach(() => {
    vi.clearAllMocks()

    // Mock des catégories
    const mockCategories = [
      {id: 1, name: 'Santé'},
      {id: 2, name: 'Éducation'},
      {id: 3, name: 'Environnement'}
    ]

    // Configurer le mock du store de campagne
    mockCreateCampaign = vi.fn().mockResolvedValue({
      data: {id: 123, slug: 'ma-nouvelle-campagne'}
    })

    vi.mocked(useCampaignStore).mockReturnValue({
      createCampaign: mockCreateCampaign,
      errorsFormCampaign: null,
      loading: false
    } as any)

    // Configurer le mock du store de catégories
    vi.mocked(useCategoryStore).mockReturnValue({
      getCategories: vi.fn(),
      categories: mockCategories
    } as any)

    // Initialiser Pinia
    setActivePinia(createPinia())

    // Monter le composant avec les stubs nécessaires
    wrapper = mount(FormCreateCampaignView, {
      global: {
        stubs: {
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
            template: '<button :type="type || \'button\'" :disabled="loading || disabled">{{ label }}</button>'
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
          },
          'RouterLink': {
            props: ['to'],
            template: '<a href="#">Link</a>'
          }
        }
      }
    })
  })

  it('charge les catégories au montage du composant', () => {
    expect(mockGetCategories).toHaveBeenCalled()
  })

  it('appelle la méthode createCampaign avec les données correctes lors de la soumission du formulaire', async () => {
    // Simuler la saisie des données de campagne
    await wrapper.find('input[placeholder="Titre de la cagnotte"]').setValue('Ma campagne de test')
    await wrapper.find('select').setValue('2') // Sélectionner une catégorie
    await wrapper.find('input[placeholder="Ex: 10"]').setValue('100')
    await wrapper.find('textarea').setValue('Description détaillée de ma campagne de test')
    await wrapper.find('input[type="file"]').trigger('change') // Simuler l'upload d'un fichier

    // Déclencher la soumission du formulaire
    await wrapper.find('form').trigger('submit.prevent')

    // Attendre que les promesses soient résolues
    await flushPromises()

    // Vérifier que la méthode createCampaign a été appelée avec les bonnes données
    expect(mockCreateCampaign).toHaveBeenCalledWith({
      title: 'Ma campagne de test',
      description: 'Description détaillée de ma campagne de test',
      image: 'mocked-file.jpg',
      target_amount: 10000, // 100 * 100 comme dans le code
      category_id: '2'
    })

    // Vérifier que la redirection a eu lieu
    expect(mockRouter.push).toHaveBeenCalledWith({
      name: 'campaign',
      params: {slug: 'ma-nouvelle-campagne', id: 123}
    })
  })
})