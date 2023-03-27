import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
    app.component('index-member-services-fields', IndexField)
    app.component('detail-member-services-fields', DetailField)
    app.component('form-member-services-fields', FormField)
})
