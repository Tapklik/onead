<template>
	<v-navigation-drawer dark persistent :enable-resize-watcher="true" v-model="drawer" :clipped="false" class="tapklik-drawer elevation-9">
		<div class="logo">
			<img width="50" src="/images/tapklik-logo-square-inner.png">
		</div>
		<v-list three-line class="pt-5">
			<template v-for="item in items">
				<v-list-tile v-bind:key="item.title" tag="a" v-bind:href="item.link" @click="">
					<v-list-tile-content>
						<v-list-tile-title href="item.link" class="text-xs-center">
							<v-icon>{{ item.icon }}</v-icon>
						</v-list-tile-title>
						<v-list-tile-title class="text-xs-center">
							<span class="item-title">{{ item.title }}</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
			</template>
		</v-list>
	</v-navigation-drawer>
</template>

<script>
	export default {
		data () {
			return {
				drawer: true,
				items: [
				{ title: 'Dashboard', icon: 'apps', link: '/admin/dashboard' },
				{ title: 'Campaigns', icon: 'add_to_queue', link: '/admin/campaigns' },
				{ title: 'Creatives', icon: 'crop_original', link: '/admin/creatives' },
				{ title: 'Reports', icon: 'insert_chart', link: '/admin/reports' },
				{ title: 'Billing', icon: 'monetization_on', link: '/admin/billing' },
				{ title: 'Settings', icon: 'settings', link: '/admin/settings' },
				],
			}
		},

		 methods: {

        }
	}
</script>