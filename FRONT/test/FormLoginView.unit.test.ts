// FormLoginView.spec.ts
import {describe, it, expect, vi, beforeEach} from 'vitest'
import {mount} from '@vue/test-utils'
import FormLoginView from '../src/pages/forms/FormLoginView.vue'
import {createPinia, setActivePinia} from 'pinia'
import {useAuthStore} from '../src/stores/useAuthStore'


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
vi.mock('@/stores/useAuthStore', () => ({
  useAuthStore: vi.fn()
}))

describe('FormLoginView - Test Unitaire', () => {
  let wrapper
  let mockLoginUser

  beforeEach(() => {
    vi.clearAllMocks()

    // Configurer le mock du store d'authentification
    mockLoginUser = vi.fn()
    vi.mocked(useAuthStore).mockReturnValue({
      loginUser: mockLoginUser,
      error: null,
      errors: {},
      token: null,
      loading: false
    } as any)

    // Initialiser Pinia
    setActivePinia(createPinia())

    // Monter le composant avec les stubs nécessaires
    wrapper = mount(FormLoginView, {
      global: {
        stubs: {
          'Header': true,
          'Main': {
            template: '<main><slot /></main>'
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
            template: '<div class="error-message"><slot /></div>'
          },
          'RouterLink': {
            props: ['to'],
            template: '<a href="#">Link</a>'
          }
        }
      }
    })
  })

  it('appelle la méthode loginUser avec les données correctes lors de la soumission du formulaire', async () => {
    // Simuler la saisie des données utilisateur
    const emailInput = wrapper.find('input[placeholder="Email"]')
    const passwordInput = wrapper.find('input[placeholder="Mot de passe"]')

    await emailInput.setValue('test@example.com')
    await passwordInput.setValue('password123')

    // Déclencher la soumission du formulaire
    await wrapper.find('form').trigger('submit.prevent')

    // Vérifier que la méthode loginUser a été appelée avec les bonnes données
    expect(mockLoginUser).toHaveBeenCalledWith({
      email: 'test@example.com',
      password: 'password123'
    })
  })
})