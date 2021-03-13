<template>
  <v-card
    class="mx-auto"
    max-width="350"
  >
    <v-list dense>
      <v-list-item
        v-for="(item, i) in Beranda"
        :key="i"
        link
      >
        <v-list-item-icon>
          <v-icon v-text="item.icon"></v-icon>
        </v-list-item-icon>
        <div class="mr-3">
          <input type="checkbox" v-text="item.title">
        </div>
        <v-list-item-content>
          <v-list-item-title v-text="item.text"></v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      
      <v-list-group
        v-for="item in Master"
        :key="item.title"
        v-model="item.active"
        :prepend-icon="item.action"
        no-action
      >
        <template v-slot:activator>
          <div class="mr-3">
            <input type="checkbox" v-text="item.title" v-model="item.active">
          </div>
          <v-list-item-content>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item-content>
        </template>

        <v-list-item
          v-for="child in item.items"
          :key="child.title"
          link
        >
          <div class="mr-3">
            <input type="checkbox" v-text="child.title" v-model="child.active">
          </div>
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

      Master: [
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