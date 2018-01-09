<template>
  <div id="loader" v-show="loading">
    <div class="loader-container">
      <div class="spinner">
        <div class="v-tk" v-bind:style="spinnerStyle">
        </div>
        <div class="loader-logo">
          <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
          :width="dim" :height="dim" viewBox="0 0 365.401 365.4" enable-background="new 0 0 365.401 365.4" xml:space="preserve">
          <path fill="#F79034" d="M314.245,288.389c0,14.28-11.576,25.855-25.855,25.855H77.012c-14.28,0-25.855-11.575-25.855-25.855V77.011
          c0-14.28,11.575-25.855,25.855-25.855h211.377c14.279,0,25.855,11.575,25.855,25.855V288.389z"/>
          <path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M250.088,288.913c-7.958-1.089-12.613-6.598-16.523-12.783
          c-8.493-13.438-16.781-27.008-25.125-40.541c-6.691-10.854-13.271-21.777-20.025-32.592c-6.654-10.656-13.412-21.247-20.253-31.783
          c-1.369-2.108-1.402-3.363,0.475-5.29c18.007-18.49,35.861-37.131,53.829-55.659c4.27-4.402,9.002-8.176,15.481-8.822
          c7.837-0.782,14.624,1.285,19.383,7.803c4.642,6.36,5.155,13.432,0.729,19.925c-3.864,5.669-8.396,11-13.282,15.824
          c-8.058,7.953-16.572,15.452-25.053,22.964c-1.889,1.673-1.744,2.753-0.535,4.649c16.715,26.193,33.377,52.418,50.003,78.668
          c3.138,4.953,5.909,9.938,5.558,16.282c-0.645,11.669-8.19,19.909-17.602,20.865c-0.267,0.026-0.507,0.319-0.76,0.489
          C254.288,288.913,252.188,288.913,250.088,288.913z"/>
          <path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M282.389,288.913c1.891,0,3.781,0,5.67,0
          c0.359,0.182,0.703,0.471,1.082,0.532c6.532,1.073,11.725,4.395,15.139,9.963c1.794,2.927,2.655,6.423,3.938,9.661
          c0,1.89,0,3.779,0,5.669c-0.197,0.464-0.488,0.909-0.576,1.392c-1.168,6.378-4.418,11.496-9.912,14.822
          c-2.941,1.781-6.43,2.658-9.67,3.943c-1.889,0-3.779,0-5.67,0c-0.357-0.182-0.7-0.465-1.08-0.533
          c-8.628-1.559-14.35-6.629-17.586-14.632c-0.648-1.603-1.002-3.325-1.49-4.992c0-1.89,0-3.779,0-5.669
          c0.188-0.352,0.484-0.688,0.545-1.061c1.044-6.545,4.363-11.734,9.941-15.146C275.652,291.069,279.149,290.199,282.389,288.913z"/>
          <path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M152.965,289.052c-4.808-0.834-9.691-1.366-14.411-2.553
          c-15.103-3.799-24.368-13.533-27-28.809c-1.557-9.035-2.452-18.287-2.552-27.453c-0.314-29.173-0.116-58.352-0.116-87.526
          c0-1.251,0-2.503,0-3.906c-3.95-0.31-7.784-0.48-11.583-0.936c-8.994-1.079-14.872-7.503-14.881-16.074
          c-0.009-8.395,6.071-14.953,15.003-16.021c3.631-0.434,7.294-0.611,11.461-0.947c0-0.903-0.014-2.002,0.001-3.103
          c0.204-13.739,0.342-27.479,0.64-41.217c0.264-12.159,9.405-21.57,21.3-22.145c12.041-0.582,23.135,9.251,23.324,21.376
          c0.409,26.22,0.52,52.443,0.617,78.666c0.11,29.909,0.018,59.82,0.155,89.728c0.022,4.899,0.414,9.856,1.262,14.677
          c1.283,7.302,6.076,11.243,13.445,10.886c5.704-0.279,11.405-1.215,17.039-2.236c9.341-1.697,16.907,2.069,19.437,10.063
          c0.438,1.378,0.692,2.814,1.031,4.224c0,0.419,0,0.839,0,1.259c-0.965,7.341-4.841,12.689-11.566,15.578
          c-4.463,1.918-9.18,3.4-13.919,4.479c-4.643,1.059-9.459,1.359-14.2,1.99C162.625,289.052,157.795,289.052,152.965,289.052z"/>
          </svg>
        </div>
      </div>
      <div class="loader-text">LOADING</div>
     </div> 
  </div>
</template>

<script>
  export default {

    name: 'TkLoader',

    props: {
      loading: {
        type: Boolean,
        default: true
      },
      size: {
        type: String,
        default: 'sm'
      }
    },

    mounted () {
      console.log("spinner is loaded:  " + this.loading)
    },

    computed: {
      spinnerStyle () {
        return {
          height: this.dim,
          width: this.dim,
          borderWidth: this.border,
          borderStyle: 'solid',
          borderColor: '#f76c06',
          borderRadius: '10%',
          background: 'transparent'
        }
      },
      dim () {
        if(this.size=='sm') {return '35px'}
        else if(this.size=='lg') {return '80px'}
      },     
      border () {
        if(this.size=='sm') {return '6px'}
        else if(this.size=='lg') {return '11px'}
      },
    }
  }
</script>

<style>
  #loader {
    z-index: 10000;
    position: fixed;
    display: block;
    width: 100%;
    height: 100%;
    opacity: 0.95;
    background-color: #fff;
    color: #777;
  }

  .loader-container {
    position:fixed;
    top:0;
    left:0;
    right:0;
    bottom:0;
    margin:auto;
    height:60px;
    width:130px;
  }

  .spinner
  {
    width:60px;
    height:60px;
    position:fixed;
  }

  .v-tk
  {
    -webkit-animation: v-tkDelay 1.0s 0s infinite ease-out ;
    animation: v-tkDelay 1.0s 0s infinite ease-out ;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    position:absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    margin:auto;
  }

  .loader-logo {
    position:absolute;
    width:35px;
    height:35px;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
  }

  .loader-text {
    float: right;
    margin-top: 20px;
    font-size:15px;
    line-height:20px;
  }

  @-webkit-keyframes v-tkDelay
  {
    0%
    {
      -webkit-transform: rotate(-45deg) scale(0.95);
      transform: rotate(-45deg) scale(0.95);
    }
    50%
    {
      -webkit-transform: rotate(0deg) scale(1.1);
      transform: rotate(0deg) scale(1.1);
    }
    100%
    {
      -webkit-transform: rotate(45deg) scale(0.95);
      transform: rotate(45deg) scale(0.95);
    }
  }

  @keyframes v-tkDelay
  {
    0%
    {
      -webkit-transform: rotate(-45deg) scale(0.95);
      transform: rotate(-45deg) scale(0.95);
    }
    50%
    {
      -webkit-transform: rotate(0deg) scale(1.1);
      transform: rotate(0deg) scale(1.1);
    }
    100%
    {
      -webkit-transform: rotate(45deg) scale(0.95);
      transform: rotate(45deg) scale(0.95);
    }
  }
</style>