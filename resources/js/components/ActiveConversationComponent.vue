<template>
  <b-row no-gutters class="h-100">
    <b-col cols="8">
      <div class="card h-100">
        <div class="card-header text-center">
          Active Conversation
        </div>
        <div class="card-body h-100">
          <b-media vertical-align="center" class="mb-2">
            <template v-slot:aside>
              <b-img rounded="circle" src="https://picsum.photos/250/250" width="50" height="50" blank-color="#ccc" alt="placeholder"></b-img>
            </template>
            <b-card no-body>
              <p class="mb-0 small p-2">
              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.
              Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac
              nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
              </p>
            </b-card>
          </b-media>
          <b-media right-align vertical-align="center" class="mb-2">
            <template v-slot:aside>
              <b-img rounded="circle" src="https://picsum.photos/250/250" width="50" height="50" blank-color="#ccc" alt="placeholder"></b-img>
            </template>
            <b-card no-body>
              <p class="mb-0 small p-2">
              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.
              Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac
              nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
              </p>
            </b-card>
          </b-media>
          <b-media right-align vertical-align="center" class="mb-2">
            <template v-slot:aside>
              <b-img rounded="circle" src="https://picsum.photos/250/250" width="50" height="50" blank-color="#ccc" alt="placeholder"></b-img>
            </template>
            <b-card no-body>
              <p class="mb-0 small p-2">
              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.
              Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac
              nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
              </p>
            </b-card>
          </b-media>
        </div>
        <div class="card-footer p-2">
          <b-form class="mb-0">
            <b-input-group>
              <b-form-input class="p-0"
                type="text"
                placeholder="Type your message..."
              ></b-form-input>
              <b-input-group-append>
                <b-button variant="primary">Send</b-button>
              </b-input-group-append>
            </b-input-group>
          </b-form>
        </div>
      </div>
    </b-col>

    <b-col cols="4" class="text-center">
      <b-img rounded="circle" src="https://picsum.photos/250/250/?image=59" width="120" height="120" blank-color="#777" alt="img" class="m-1"></b-img>
      <p>Selected User</p>
      <hr>
      <b-form-checkbox
          id="checkbox-1"
          v-model="status"
          name="checkbox-1"
          value="accepted"
          unchecked-value="not_accepted"
          >
          Desabled notifications
      </b-form-checkbox>
    </b-col>
  </b-row>
</template>

<script>
    export default {
      data(){
        return {
        }
      },
      mounted() {
          console.log('Component mounted.')
      }
    }
</script>