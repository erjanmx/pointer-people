// tests/js/components/App.spec.js
import { mount } from '@vue/test-utils';
import expect from 'expect';
import App from '../../../resources/js/components/App';

describe('App component', () => {
    it('has Search text', () => {
        const wrapper = mount(App);

        expect(wrapper.html()).toContain('Search');
    });
});
