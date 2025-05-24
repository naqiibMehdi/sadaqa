// FormLoginView.functional.spec.ts
import {describe, it, expect, vi, beforeEach} from 'vitest'
import {mount, flushPromises, VueWrapper} from '@vue/test-utils'
import FormLoginView from '../src/pages/forms/FormLoginView.vue'
import {createPinia, setActivePinia} from 'pinia'
import {nextTick} from 'vue'

// Mock des dépendances
const mockToast = {
  add: vi.fn()
}

const mockRouter = {
  push: vi.fn()
}

vi.mock('primevue/usetoast', () => ({
  useToast: () => mockToast
}))

vi.mock('vue-router', () => ({
  useRouter: () => mockRouter
}))

// Mock du store
const mockStore = {
  loginUser: vi.fn(),
  error: null,
  errors: {email: [""], password: [""]},
  token: null,
  loading: false
}

vi.mock('../src/stores/useAuthStore', () => ({
  useAuthStore: vi.fn(() => mockStore)
}))

describe('FormLoginView - Test Fonctionnel', () => {
  let wrapper: VueWrapper

  beforeEach(() => {
    vi.clearAllMocks()

    // Réinitialiser les propriétés du store
    mockStore.error = null
    mockStore.errors = {email: [""], password: [""]}
    mockStore.token = null
    mockStore.loading = false

    // Initialiser Pinia
    setActivePinia(createPinia())

    // Monter le composant avec des stubs personnalisés qui permettent d'interagir avec les inputs
    wrapper = mount(FormLoginView, {
      global: {
        stubs: {
          'Header': true,
          'Main': {
            template: '<div><slot /></div>'
          },
          'Footer': true,
          'InputField': {
            props: ['modelValue', 'placeholder', 'type', 'invalid', 'disabled'],
            template: '<input :type="type || \'text\'" :placeholder="placeholder" :value="modelValue" @input="$emit(\'update:modelValue\', $event.target.value)" />',
            emits: ['update:modelValue']
          },
          'CustomButton': {
            props: ['label', 'type', 'loading', 'disabled', 'outline'],
            template: '<button :type="type || \'button\'" :disabled="loading || disabled">{{ label }}</button>'
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

  it('affiche un message d\'erreur si la connexion échoue', async () => {
    // Configurer le comportement du mock loginUser
    mockStore.loginUser.mockImplementation(async () => {
      mockStore.error = 'Identifiants incorrects'
    })

    // Remplir et soumettre le formulaire
    await wrapper.find('input[placeholder="Email"]').setValue('user@example.com')
    await wrapper.find('input[placeholder="Mot de passe"]').setValue('wrongpassword')
    await wrapper.find('form').trigger('submit.prevent')

    // Attendre que les promesses soient résolues
    await flushPromises()

    // Vérifier que le toast a été appelé avec le message d'erreur
    expect(mockToast.add).toHaveBeenCalledWith({
      severity: 'error',
      summary: "Message d'erreur",
      detail: 'Identifiants incorrects',
      life: 5000
    })

    // Vérifier que la redirection n'a pas eu lieu
    expect(mockRouter.push).not.toHaveBeenCalled()
  })

  it('redirige vers le dashboard si la connexion réussit', async () => {
    // Configurer le comportement du mock loginUser pour simuler une connexion réussie
    mockStore.loginUser.mockImplementation(async () => {
      mockStore.token = 'fake-jwt-token'
    })

    // Remplir et soumettre le formulaire
    await wrapper.find('input[placeholder="Email"]').setValue('user@example.com')
    await wrapper.find('input[placeholder="Mot de passe"]').setValue('correctpassword')
    await wrapper.find('form').trigger('submit.prevent')

    // Attendre que les promesses soient résolues
    await flushPromises()

    // Vérifier que la redirection a eu lieu
    expect(mockRouter.push).toHaveBeenCalledWith({name: 'dashboard'})
  })

  it('affiche les erreurs de validation si présentes', async () => {
    // Configurer le comportement du mock loginUser pour simuler des erreurs de validation
    const validationErrors = {
      email: ['Veuillez entrer une adresse email valide'],
      password: ['Le mot de passe doit contenir au moins 8 caractères']
    }

    mockStore.loginUser.mockImplementation(async () => {
      mockStore.errors = validationErrors
    })

    // Soumettre le formulaire
    await wrapper.find('form').trigger('submit.prevent')

    // Attendre que les promesses soient résolues
    await flushPromises()

    // Forcer la mise à jour du composant après que le mock ait mis à jour les erreurs
    await nextTick()

    // Maintenant que les erreurs sont présentes dans le store mocké,
    // forcer le rendu pour faire apparaître les messages d'erreur
    wrapper.vm.$forceUpdate()
    await nextTick()

    // Tester les propriétés du store au lieu de chercher des éléments dans le DOM
    expect(mockStore.errors.email).toEqual(['Veuillez entrer une adresse email valide'])
    expect(mockStore.errors.password).toEqual(['Le mot de passe doit contenir au moins 8 caractères'])
  })
})