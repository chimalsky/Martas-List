import $ from 'jquery'

import 'jquery-ui/themes/base/core.css'
import 'jquery-ui/themes/base/draggable.css'
import 'jquery-ui/ui/core'
import 'jquery-ui/ui/widgets/draggable'

import util_browser from './utils/browser'

export default Frame

function Frame(params) {
  this.img
  this.$img
  if (params.img) {
    this.loadImg(params.img)
  }

  this._activated = false
  if (params.frame) {
    this.activate(params.frame)
  }

  this.$nav = $('nav')

  this._zoom = 1
  this._center = undefined
  this._textLoaded = false
  this._explorable = true

  // This maintains focal point by always preserving
  // the center of the image no matter how
  // viewport is resized.
  if (params.hasOwnProperty('recenter')) {
    this._recenter = params.recenter
  } else {
    this._recenter = true
  }

  if (params.text) {
    this.loadText(params.text)
  }
}

Frame.prototype.activate = function(el) {
  if (el) {
    this.$frame = $(el)
    this.$frame.addClass('frame')
  }
  
  this._activated = true
}

Frame.prototype.enableExplore = function() {
  this.$img.draggable({disabled: false})
  this._explorable = true
}

Frame.prototype.disableExplore = function() {
  this.$img.draggable({disabled: true})

  this._explorable = false
}

Frame.prototype.events = function() {
  var that = this

  this.$img.off('dblclick').on('dblclick', function(ev) {
    if (!that._explorable) {
      return
    }

    var click = {
      x: ev.offsetX,
      y: ev.offsetY
    }

    var point = that.getProjection(click)

    var zoom = that._zoom
    that.zoomImg(zoom + .1, point)
  })

  this.$img.off('mousewheel').on('mousewheel', function(ev) {   
    if (!that._explorable) {
      return
    }
    var direction = ev.originalEvent.deltaY < 0 ? 'down' : 'up'
    var zoom = that._zoom

    if (direction == 'up') {
      that.zoomImg(zoom + .02)
    }

    if (direction == 'down') {  
      that.zoomImg(zoom - .01)
    }
    ev.preventDefault()
  })

  var recenter = util_browser.debounce(function() {
      that.repositionImg(that._center)
    }, 250)

  if (this._recenter) {
    $(window).resize(recenter)
  }

  console.log(this.$frame, this.$img)
  var containment = [-this.$frame.width(), 
    +(this.$frame.height() - this.$img.height()), 
    this.$img.width() + this.$frame.width(), 
    0]
    console.log(containment)
  this.$img.draggable({
    stop: function(event, ui) {
      that._center = that.getCenter()
    },
    //containment: containment
  })
  console.log(this.$img.draggable('option', 'containment'))
}

Frame.prototype.loadImg = function(img) {
  if (img instanceof $) {
    console.log('instance of')
    this.$img = img
    this.img = this.$img[0]
  } else {
    console.log('not instance of')
    this.img = img
    this.$img = $(this.img)
  }

  console.log(this)

  var src = this.getImgSrc()

  if (this.$frame.find('div.img-container').length) {
    var el = this.$f  rame.find('div.img-container').children('img')
    el.attr('src', src)
  } else {
    var containerHtml = "<div class='img-container'></div>"
    var el = "<img src='" + src + "' />"
    
    var container = $(containerHtml).appendTo(this.$frame)
    var imgEl = $(el).appendTo(container)
  }

  console.log(img, this, src)

  this.$img = $(this.$frame.find('div.img-container').children('img'))

  var that = this
  setTimeout(function() {
    that.events(), 1})
}

Frame.prototype.refresh = function() {
  this._zoom = this.getZoom()
  this._center = this.getCenter()
}

Frame.prototype.containImg = function() {
  if (!this.$img) { return }
  
  this.$img.attr('width', '100%')
    .attr('left', 0)
    .attr('top', 0);

  this.refresh()

  console.log(this)
}

Frame.prototype.revealImg = function(settings) {
  var that = this

  this.disableExplore()

  settings = settings || {}

  var speed = settings.speed || 8000

   this.$img.animate({
    top: 0,
    left: 0,
    width: '100%'
  }, speed, function() {
    that._zoom = that.getZoom()
    that._center = that.getCenter()
    that.enableExplore()
  })
}

Frame.prototype.findImgPoint = function(click) {
  var imgPos = {
    x: -this.$img.position().left,
    y: -this.$img.position().top
  }
  var x = imgPos.x + click.x
  var y = imgPos.y + click.y

  return {
    x: x,
    y: y
  }
}

Frame.prototype.getImgSrc = function() {
  console.log(this.img)
  if (this.img) { return this.img.src }
  return undefined
}

Frame.prototype.getZoom = function() {
  var zoom = this.$img.prop('width') / this.$img.prop('naturalWidth')
  return zoom
}

Frame.prototype.getCenter = function() {
  var frame = {
    x: this.$frame.prop('clientWidth') / 2,
    y: this.$frame.prop('clientHeight') / 2
  }

  var position = this.$img.position()

  var img = {
    x: -position.left,
    y: -position.top,
    width: this.$img.prop('width'),
    height: this.$img.prop('height')
  }

  var center = {
    x: (img.x + frame.x) / img.width,
    y: (img.y + frame.y) / img.height
  }

  return center
}

Frame.prototype.getProjection = function(point) {
  var projection = {
    x: point.x / this.$img.prop('width'),
    y: point.y / this.$img.prop('height')
  }
  console.log('projection:', projection)
  return projection
}

Frame.prototype.repositionImg = function(point, speed) {
  speed = speed || undefined

  var frame = {
    x: this.$frame.prop('clientWidth'),
    y: this.$frame.prop('clientHeight')
  }

  var w = this.$img.prop('width'),
      h = this.$img.prop('height');

  // Halve the frame clientWidth & clientHeight
  // because we use the half value as 
  // subtractor to retain center
  var x = -( (point.x * w) /*pixels*/ - frame.x / 2 ),
      y = -( (point.y * h) /*pixels*/ - frame.y / 2 );

  console.log(x, y)

  if (!speed) {
    this.$img.css('left', x).css('top', y)
    this._center = thfis.getCenter()
    return
  }

  var that = this

  this.disableExplore()
  this.$img.animate({
    left: x,
    top: y,
  }, speed, function() {
    that._zoom = that.$img.prop('width') / that.$img.prop('naturalWidth')
    that._center = that.getCenter()
    that.enableExplore()
  })
}

Frame.prototype.zoomImg = function(zoom, point, cb) {
  if (!this.$img.prop('width')) {
    var that = this
    return setTimeout(function() {
      that.zoomImg(zoom, point)
    }, 300)
  }

  this._zoom = zoom
  var oldCenter = this.getCenter()

  var newWidth = this.$img.prop('naturalWidth') * zoom
  this.$img.css('width', newWidth)
  var newHeight = this.$img.prop('height') 

  if (point) {
    // Go kind of towards click coordinate as center, 
    // but not fully. Trying to mimic the way 
    // google maps click-zoom works.
    var pointRatio = {
      x: Math.abs( oldCenter.x - (point.x / 10) ),
      y: Math.abs( oldCenter.y - (point.y / 10) )
    }

    this.repositionImg(point)
    this._center = point
  } else {
    this.repositionImg(oldCenter)
  }
}

Frame.prototype.loadText = function(textTitle) {
  var that = this

  utils.loadMarkdown(textTitle, function(md) {
    if (that.$frame.find('div.text-hidden').length) {
      that.$frame.find('div.text-hidden').html(md)
    } else {
      var textHidden = $('<div class="text-hidden"></div>')
      textHidden.appendTo(that.$frame)
      textHidden.html(md)
    }

    that.$text = $('.text-hidden')

    that._textLoaded = true
  })
}

Frame.prototype.showText = function(index) {
  if (!this._textLoaded) {
   return
  }

  this.activeSceneIndex = index
  
  console.log('active scene:', this.activeSceneIndex)

  if (index) {
    var theText = this.$text.find('p').eq(index).html()
  } else {
    var theText = this.$text.find('p').first().html()
  }
  
  if (this.$nav.find('p.text').length) {
    this.$nav.find('p.text').css('display', 'none')
                    .html(theText).fadeIn('slow')
  } else {
    var container = $('<div class="text"></div>')
    var p = $('<p class="text" style="display: none"></p>')
        .html(theText)

    p.appendTo(container)
    container.appendTo(this.$nav)
    p.fadeIn('slow')
    console.log(this)
  }
}

Frame.prototype.getBorders = function() {
  var w = this.$img.prop('width'),
      h = this.$img.prop('height');
  var t = -this.$img.position().top,
      l = -this.$img.position().left;
  var frame = {
    w: this.$frame.prop('clientWidth'),
    h: this.$frame.prop('clientHeight')
  }
  return [
    t / h, 
    (l + frame.w) / w,
    (t + frame.h) / h,
    l / w
  ]
}

Frame.prototype.withinBorders = function(point) {
  var borders = this.getBorders()
  return borders[2] >= point.y && point.y >= borders[0] && 
    borders[3] <= point.x && point.x <= borders[1]
}


