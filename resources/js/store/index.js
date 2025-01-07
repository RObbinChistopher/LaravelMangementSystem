import { createStore, createLogger } from 'vuex'
import home from './modules/home'
import auth from './modules/auth'
import project from './modules/project'
import milestone from './modules/milestone'
import tasks from './modules/task'
import service from './modules/service'
import notification from './modules/notification'
import dashboard from './modules/home'
const debug = process.env.NODE_ENV !== 'production'

export default createStore({
    modules: {
        auth,
        home,
        project,
        milestone,
        tasks,
        service,
        notification,
        dashboard ,
    },
    strict: debug,
    plugins: debug ? [createLogger()] : []
})
