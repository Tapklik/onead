<template>
	<v-navigation-drawer 
	dark 
	persistent 
	:enable-resize-watcher="true" 
	v-model="$root.drawer" 
	:clipped="false"
	class="tapklik-drawer elevation-9" 
	style="overflow-y:hidden"
	>
		<div class="logo mb-4">
			<img width="60" src="/images/tapklik-logo-square-inner.png">
		</div>
		<v-list three-line class="pt-5">
			<v-list-tile tag="a" href="/admin/dashboard" @click="">
				<v-list-tile-content>
					<v-list-tile-title href="/admin/dashboard" class="text-xs-center">
						<v-icon>apps</v-icon>
					</v-list-tile-title>
					<v-list-tile-title class="text-xs-center">
						<span class="item-title">Dashboard</span>
					</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
			<v-list-tile tag="a" href="/admin/creatives" @click="">
				<v-list-tile-content>
					<v-list-tile-title href="/admin/creatives" class="text-xs-center">
						<v-icon>crop_original</v-icon>
					</v-list-tile-title>
					<v-list-tile-title class="text-xs-center">
						<span class="item-title">Creatives</span>
					</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
			<v-list-tile tag="a" href="/admin/campaigns" @click="">
				<v-list-tile-content>
					<v-list-tile-title href="/admin/campaigns" class="text-xs-center">
						<v-icon>add_to_queue</v-icon>
					</v-list-tile-title>
					<v-list-tile-title class="text-xs-center">
						<span class="item-title">Campaigns</span>
					</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
			<v-list-tile tag="a" href="/admin/reports" @click="">
				<v-list-tile-content>
					<v-list-tile-title href="/admin/reports" class="text-xs-center">
						<v-icon>insert_chart</v-icon>
					</v-list-tile-title>
					<v-list-tile-title class="text-xs-center">
						<span class="item-title">Reports</span>
					</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
			<v-list-tile tag="a" href="/admin/billing" @click="">
				<v-list-tile-content>
					<v-list-tile-title href="/admin/billing" class="text-xs-center">
						<v-icon>monetization_on</v-icon>
					</v-list-tile-title>
					<v-list-tile-title class="text-xs-center">
						<span class="item-title">Billing</span>
					</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
		</v-list>
	</v-navigation-drawer>
</template>

<script>
	export default {
		data () {
			return {

			}
		},

		 methods: {

        }
	}
</script>