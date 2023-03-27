import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
    app.component('index-workspace-services-fields', IndexField)
    app.component('detail-workspace-services-fields', DetailField)
    app.component('form-workspace-services-fields', FormField)
})
