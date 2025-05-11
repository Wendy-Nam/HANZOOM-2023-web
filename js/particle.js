// Define the Particle class
class Particle {
  constructor({ x, y, rotation, shape, color, size, duration, parent }) {
    this.x = x;
    this.y = y;
    this.parent = parent;
    this.rotation = rotation;
    this.shape = shape;
    this.color = color;
    this.size = size;
    this.duration = duration;
    this.children = document.createElement('div');
  }

  draw() {
    this.children.style.setProperty('--x', this.x + 'px');
    this.children.style.setProperty('--y', this.y + 'px');
    this.children.style.setProperty('--r', this.rotation + 'deg');
    this.children.style.setProperty('--c', this.color);
    this.children.style.setProperty('--size', this.size + 'px');
    this.children.style.setProperty('--d', this.duration + 'ms');
    this.children.className = `shape ${this.shape}`;
    this.parent.append(this.children);
  }

  animate() {
    this.draw();

    const timer = setTimeout(() => {
      this.parent.removeChild(this.children);
      clearTimeout(timer);
    }, this.duration);
  }
}

// Function to animate particles
function animateParticles({ total, parent }) {
  const colors = ['#FC4F4F', '#FFBC80', '#FF9F45', '#F76E11'];
  const shapes = ['heart'];

  const randomIntBetween = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1) + min);
  }

  for (let i = 0; i < total; i++) {
    const particle = new Particle({
      x: randomIntBetween(-100, 150),
      y: randomIntBetween(-50, -150),
      rotation: randomIntBetween(-360 * 1, 360 * 2),
      shape: shapes[randomIntBetween(0, shapes.length - 1)],
      color: colors[randomIntBetween(0, colors.length - 1)],
      size: randomIntBetween(3, 5),
      duration: randomIntBetween(400, 800),
      parent
    });
    particle.animate();
  }
}
