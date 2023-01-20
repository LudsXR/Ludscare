export default {
  data() {
    return {
        is_loggedIn: false,
        User: '',
    };
  },
    methods: {
        checkLoggedIn()
        {
            var userExist = JSON.parse(localStorage.getItem('User'));
         if(userExist)
         {
             this.is_loggedIn = true;
            this.User = userExist;
         }
        }
    }
  };
