<template>
  <v-card
    class="mx-auto"
    max-width="500"
  >

    <v-list dense>
      <v-list-item-group
        v-model="selectedItem"
        color="primary"
      >
        <v-list-item
          v-for="(item, i) in Beranda"
          :key="i"
        >
            
            <v-list-item-icon>
              <v-checkbox class="mt-n1"></v-checkbox>
              <!-- <v-icon v-text="item.icon"></v-icon> -->
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title v-text="item.text"></v-list-item-title>
            </v-list-item-content>

        </v-list-item>
      </v-list-item-group>

      <v-list-group
        v-for="item in items"
        :key="item.title"
        v-model="item.active"
        
        no-action
      >
        <!-- :prepend-icon="item.action" -->
        <template v-slot:activator>
          <v-checkbox></v-checkbox>
          <v-list-item-content>

            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item-content>
        </template>

        <v-list-item
          v-for="child in item.items"
          :key="child.title"
          link
        >
          <v-checkbox></v-checkbox>
          <v-list-item-content>
            <v-list-item-title v-text="child.title"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
    </v-list>
  </v-card>
</template>

<script>
  export default {
    data: () => ({
      Beranda: [
        { text: 'Beranda', icon: 'mdi-home' },
      ],

      items: [
        {
          action: 'mdi-database',
          items: [
            { title: 'Karyawan' },
            { title: 'UserMenu' },
          ],
          title: 'Master',
        },
        
      ],

      
    }),
  }
</script>