<template>
  <v-card
    class="mx-auto"
    max-width="300"
    tile
  >
    <v-list flat dense nav>
      <v-list-item-group
        v-model="selectedItem"
        color="primary"
      >
        <v-list-item
          v-for="(item, i) in Beranda"
          :key="i"
        >
          <template v-slot:default="{ active }">
            <v-list-item-action>
              <v-checkbox :input-value="active"></v-checkbox>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title v-text="item.text"></v-list-item-title>
            </v-list-item-content>
          </template>
        </v-list-item>
      </v-list-item-group>

      <v-list-group
        v-for="item in Master"
        :key="item.title"
        
        no-action
      >
        <template v-slot:activator>
          <v-list-item-action>
            <v-checkbox :input-value="active"></v-checkbox>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item-content>
        </template>

        <v-list-item
          v-for="child in item.items"
          :key="child.title"
          link
        >
          <template v-slot:default="{ active }">
            <v-list-item-action>
              <v-checkbox :input-value="active"></v-checkbox>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title v-text="child.title"></v-list-item-title>
            </v-list-item-content>
          </template>
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
            { title: 'UserMenu' }

          ],
          title: 'Master',
        },
      ],
    }),
  }
</script>