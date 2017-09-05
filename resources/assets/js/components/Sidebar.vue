

<template>
	<v-navigation-drawer persistent dark :mini-variant.sync="mini" v-model="drawer" overflow class="tapklik-drawer elevation-9">
		<v-toolbar flat class="transparent">
			<v-list class="pa-2">
				<v-list-tile avatar tag="div">
					<v-list-tile-avatar>
						<img src="https://randomuser.me/api/portraits/men/85.jpg" />
					</v-list-tile-avatar>
					<v-list-tile-content>
						<v-list-tile-title>John Leider</v-list-tile-title>
					</v-list-tile-content>
					<v-list-tile-action>
						<v-btn icon @click.native.stop="mini = !mini">
							<v-icon>chevron_left</v-icon>
						</v-btn>
					</v-list-tile-action>
				</v-list-tile>
			</v-list>
		</v-toolbar>
		<v-list two-line class="pt-5">
			<template v-for="item in items">
				<v-divider class="ma-0"></v-divider>
				<v-list-tile v-bind:key="item.title" tag="a" @click="">
					<v-list-tile-avatar>
						<v-icon>{{ item.icon }}</v-icon>
					</v-list-tile-avatar>
					<v-list-tile-content>
						<v-list-tile-title class="item-title" v-html="item.title"></v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
			</template>
			<v-divider class="ma-0"></v-divider>
		</v-list>
	</v-navigation-drawer>
</template>

<script>
	export default {
		data () {
			return {
				drawer: true,
				items: [
				{ title: 'Dashboard', icon: 'apps' },
				{ title: 'Create Campaign', icon: 'add_to_queue' },
				{ title: 'Edit Campaign', icon: 'airplay' },
				{ title: 'Manage Ads', icon: 'crop_original' },
				{ title: 'View Reports', icon: 'show_chart' },
				{ title: 'Billing', icon: 'monetization_on' },
				],
				mini: false,
				right: null
			}
		},

		 methods: {

            test() {
                console.log("hey");
            },
        }
	}
</script>