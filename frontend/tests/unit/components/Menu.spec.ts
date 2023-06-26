import {mount, shallowMount} from '@vue/test-utils'
import Menu from "@/components/Menu.vue";
import {User} from "@/types/user";

describe('Menu.vue', () => {
    it('shows username', () => {

        const user: User = {
            email: "",
            name: "Test User",
            id: 0
        }

        const wrapper = mount(Menu, {
            propsData: {user: user}
        })
        expect(wrapper.text()).toMatch("Test User")
    })
})
