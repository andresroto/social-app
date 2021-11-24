require('./bootstrap');

require('alpinejs');

// Vue 
import { createApp } from 'vue'; 
import mitt from 'mitt'; 
import StatusForm from './components/StatusForm.vue';
import StatusList from './components/StatusList.vue';
import FriendshipBtn from './components/FriendshipBtn.vue';
import AcceptFriendshipBtn from './components/AcceptFriendshipBtn.vue';
import NotificationList from './components/NotificationList.vue';
import StatusListItem from './components/StatusListItem.vue';
import LikeBtn from './components/LikeBtn.vue';
import CommentList from './components/CommentList.vue';
import CommentForm from './components/CommentForm.vue';
import CommentListItem from './components/CommentListItem.vue';


// EventBus
const EventBus = mitt();

const app = createApp({}); 

app.config.globalProperties.EventBus = EventBus; 

// Components
app.component('status-form', StatusForm)
    .component('status-list', StatusList)
    .component('friendship-btn', FriendshipBtn)
    .component('accept-friendship-btn', AcceptFriendshipBtn)
    .component('notification-list', NotificationList)
    .component('status-list-item', StatusListItem)
    // .component('like-btn', LikeBtn)
    // .component('comment-list', CommentList)
    // .component('comment-form', CommentForm)
    // .component('comment-list-item', CommentListItem)
    .mount('#app'); 